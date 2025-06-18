<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuario;
use App\Models\UsuarioColegioModel;
use App\Models\DispositivoModel; 

class AdminController extends Controller
{
    public function index()
    {
        // Verificar que el usuario tenga el rol de admin
        if (session()->get('idrol') !== '1') {
            return redirect()->to('/login');
        }
    
        $idcolegio = session()->get('idcolegio'); // Colegio del admin
    
        $db = \Config\Database::connect();
    
        // Obtener directivos asociados al colegio desde la tabla intermedia
        $queryDirectivos = $db->table('usuario_colegio uc')
            ->select('u.idusuario, u.usuario, u.email')
            ->join('usuarios u', 'u.idusuario = uc.idusuario')
            ->where('uc.idcolegio', $idcolegio)
            ->where('uc.idrol', 2) // Rol de directivo
            ->orderBy('u.usuario', 'ASC')
            ->get();
    
        $usuarios_directivos = $queryDirectivos->getResultArray();
    
        return view('vista_admin', [
            'usuarios_directivos' => $usuarios_directivos
        ]);
    }
    

    public function guardarUsuario() {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    
        if (session()->get('idrol') !== '1') {
            return redirect()->to('/login');
        }
    
        $idcolegio = session()->get('idcolegio');
        if (empty($idcolegio)) {
            log_message('error', 'ID del colegio no disponible en sesión en guardarUsuario.');
            session()->setFlashdata('error', 'El ID del colegio no está disponible.');
            return redirect()->to('/vista_admin');
        }
    
        $usuario = $this->request->getPost('usuario');
        $email = strtolower(trim($this->request->getPost('email')));
    
        if (empty($usuario) || empty($email)) {
            session()->setFlashdata('error', 'Todos los campos son obligatorios');
            return redirect()->to('/vista_admin');
        }
    
        $usuarioModel = new \App\Models\Usuario();
        $intermedioModel = new \App\Models\UsuarioColegioModel(); 
        $idrol = 2; 
 
        $usuarioExistente = $usuarioModel->where('email', $email)->first();
    
        if ($usuarioExistente) {
            $idusuario = $usuarioExistente['idusuario'];
    
            // Verificar si ya existe la asociación
            $existeAsociacion = $intermedioModel
                ->where('idusuario', $idusuario)
                ->where('idcolegio', $idcolegio)
                ->where('idrol', $idrol)
                ->first();
    
            if ($existeAsociacion) {
                session()->setFlashdata('error', 'Este usuario ya está asociado a este colegio con este rol.');
                return redirect()->to('/vista_admin');
            }
    
        } else {
            // Crear nuevo usuario
            $passwordTemporal = bin2hex(random_bytes(4));
            $hashedPassword = password_hash($passwordTemporal, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(50));
    
            $nuevoUsuario = [
                'usuario' => $usuario,
                'email' => $email,
                'password' => $hashedPassword,
                'fecha_registro' => date('Y-m-d H:i:s'),
                'token' => $token
            ];
    
            if (!$usuarioModel->insert($nuevoUsuario)) {
                session()->setFlashdata('error', 'Error al crear el nuevo usuario.');
                return redirect()->to('/vista_admin');
            }
    
            $idusuario = $usuarioModel->insertID();
    
            // Enviar correo solo si es usuario nuevo
            $this->_enviarCorreoRecuperacionInicial($email, $usuario, $token, $idcolegio);
        }
    
        // Insertar en tabla intermedia
        $datosIntermedios = [
            'idusuario' => $idusuario,
            'idcolegio' => $idcolegio,
            'idrol' => $idrol,
        ];
    
        if (!$intermedioModel->insert($datosIntermedios)) {
            session()->setFlashdata('error', 'Error al asociar el usuario con el colegio.');
            return redirect()->to('/vista_admin');
        }
       // Enviar correo informativo (usuario ya existía)
       $this->_enviarCorreoAsociacionExistente($email, $usuario, $idcolegio);

       session()->setFlashdata('success', 'Usuario existente asociado correctamente y se envió un correo de notificación.');
       return redirect()->to('/vista_admin');
    }
    
    

    public function eliminarDirectivo($idusuario)
    {
        $idcolegio = session()->get('idcolegio');
        if (empty($idcolegio)) {
            session()->setFlashdata('error', 'ID del colegio no disponible.');
            return redirect()->to('/vista_admin');
        }
    
        $intermedioModel = new \App\Models\UsuarioColegioModel();
    
        // Buscar si existe la asociación
        $asociacion = $intermedioModel
            ->where('idusuario', $idusuario)
            ->where('idcolegio', $idcolegio)
            ->where('idrol', 2) // Directivo
            ->first();
    
        if ($asociacion) {
            if (!$intermedioModel->delete($asociacion['idusuario_colegio'])) {
                session()->setFlashdata('error', 'Hubo un error al eliminar la asociación del directivo.');
            } else {
                session()->setFlashdata('success', 'Directivo eliminado correctamente del colegio.');
            }
        } else {
            session()->setFlashdata('error', 'No se encontró la asociación del directivo con este colegio.');
        }
    
        return redirect()->to('/vista_admin');
    }
    

    public function editarDirectivo($idusuario)
    {
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($idusuario);

        if ($usuario) {
            return view('editar_directivo', ['usuario' => $usuario]);
        } else {
            session()->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->to('/vista_admin');
        }
    }

    public function guardarEdicionDirectivo()
    {
        $usuarioModel = new Usuario();

        $idusuario = $this->request->getPost('idusuario');
        $usuario = $this->request->getPost('usuario');
        $email = $this->request->getPost('email');

        if (empty($usuario) || empty($email)) {
            session()->setFlashdata('error', 'Todos los campos son obligatorios.');
            return redirect()->to('admin/editarDirectivo/' . $idusuario);
        }

        $data = [
            'usuario' => $usuario,
            'email' => $email,
        ];

        if (!$usuarioModel->update($idusuario, $data)) {
            session()->setFlashdata('error', 'Hubo un error al actualizar al directivo.');
        }

        return redirect()->to('/vista_admin');
    }

    private function _enviarCorreoRecuperacionInicial($email, $usuario, $token, $idcolegio)
    {
        $emailService = \Config\Services::email();
    
        $colegioModel = new \App\Models\ColegioModel();
        $colegio = $colegioModel->find($idcolegio);
        $nombreColegio = $colegio ? $colegio['nombre'] : 'Tu colegio';
    
        $emailService->setFrom('timbreautomatico2025@gmail.com', 'Sistema de Gestión de Timbres');
        $emailService->setTo($email);
        $emailService->setSubject('Bienvenido - Establece tu contraseña');
    
        $link = base_url("resetear_contrasena?token=$token&idcolegio=$idcolegio");

    
        $mensaje = "
            <h2>Hola $usuario,</h2>
            <p>Se ha creado una cuenta para vos en el <strong>Sistema de Gestión de Timbres</p>
            <p>Colegio:$nombreColegio</p>
            <p>Tu nombre de usuario es: $usuario </p>
            <p>Para activar tu cuenta y establecer una nueva contraseña, hacé clic en el siguiente enlace:</p>
            <p><a href='$link'>Establecer contraseña</a></p>
            <p>Si no solicitaste esto, podés ignorar este mensaje.</p>
            <br><p>Saludos,<br>Sistema de Gestión de Timbres</p>
        ";
    
        $emailService->setMessage($mensaje);
        $emailService->setMailType('html');
    
        if (!$emailService->send()) {
            log_message('error', 'Error al enviar el correo de bienvenida con enlace de recuperación a ' . $email);
        }
    }
    private function _enviarCorreoAsociacionExistente($email, $usuario, $idcolegio)
{
    $colegioModel = new \App\Models\ColegioModel();
    $colegio = $colegioModel->find($idcolegio);

    $nombreColegio = $colegio ? $colegio['nombre'] : 'un colegio';

    $emailService = \Config\Services::email();

    $emailService->setTo($email);
    $emailService->setSubject('Nueva asociacion a un colegio');

    $mensaje = "
    <h2>Hola {$usuario},</h2>

    <p>Te informamos que tu cuenta ha sido vinculada al siguiente colegio:</p>

    <p><strong>Colegio:</strong> {$nombreColegio}<br>
    <strong>Rol:</strong> Directivo</p>

    <p>A partir de ahora podés acceder con tu email a este colegio con ese rol desde el sistema.</p>

    <p>Si esta acción no fue solicitada por vos o tenés alguna duda, por favor comunicate con el administrador del sistema.</p>

    <br>
    <p>Saludos,<br>
    <strong>Sistema de Gestión de Timbres</strong></p>
";

    $emailService->setMessage($mensaje);

    $emailService->send(); // Podés agregar manejo de errores si querés
}

    public function registrar_dispositivo()
    {
        $session = session();
        $idusuario = $session->get('idusuario');
    
        if (!$idusuario) {
            return redirect()->to('/login')->with('error', 'Sesión no iniciada.');
        }
    
        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->find($idusuario);
    
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
    
        $dispositivoModel = new DispositivoModel();
        $mis_dispositivos = $dispositivoModel->getDispositivosUsuario($usuario['usuario']);
    
        return view('registrar_dispositivo', [
            'mis_dispositivos' => $mis_dispositivos
        ]);
    }

    public function eliminar_dispositivo($iddispositivo)
    {
        $dispositivoModel = new DispositivoModel();
    
        // Verificar si el dispositivo existe
        $dispositivo = $dispositivoModel->find($iddispositivo);
    
        if (!$dispositivo) {
            return redirect()->back()->with('error', 'Dispositivo no encontrado.');
        }
    
        // Eliminar
        $dispositivoModel->delete($iddispositivo);
    
        return redirect()->to('/registrar_dispositivo')->with('success', 'Dispositivo eliminado correctamente.');
    }

public function guardar_dispositivo() {
    $mac = $this->request->getPost('mac');
    $idusuario = session()->get('idusuario');
    $idcolegio = session()->get('idcolegio');

    if (!preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $mac)) {
        return redirect()->back()->with('error', 'La dirección MAC no tiene un formato válido.');
    }

    $dispositivoModel = new \App\Models\DispositivoModel();

    // Verificar si la MAC existe en la base de datos
    $dispositivoExistente = $dispositivoModel
        ->where('mac', $mac)
        ->first();

    if (!$dispositivoExistente) {
        // No se permite registrar MACs que no existen en la base de datos
        return redirect()->back()->with('error', 'Esta MAC no está autorizada para ser registrada.');
    }

    if (!is_null($dispositivoExistente['idusuario']) || !is_null($dispositivoExistente['idcolegio'])) {
        // Ya está asociada a alguien, no se puede volver a usar
        return redirect()->back()->with('error', 'Esta MAC ya está registrada y asociada a un usuario y colegio.');
    }

    // Actualizar la entrada existente con los datos del usuario y colegio
    $dispositivoModel->update($dispositivoExistente['iddispositivo'], [
        'idusuario' => $idusuario,
        'idcolegio' => $idcolegio
    ]);

    return redirect()->to('registrar_dispositivo')->with('success', 'Dispositivo registrado con éxito.');
}

}
