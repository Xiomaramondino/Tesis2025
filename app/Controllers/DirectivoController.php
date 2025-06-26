<?php
namespace App\Controllers;

use App\Models\Usuario;

class DirectivoController extends BaseController
{
    protected $Usuario;

    public function __construct()
    {
        $this->Usuario = new Usuario();
    }

    public function gestionarUsuarios()
    {
        $idcolegio = session()->get('idcolegio');
    
        $db = \Config\Database::connect();
    
        $lectores = $db->table('usuario_colegio uc')
            ->select('u.idusuario, u.usuario, u.email')
            ->join('usuarios u', 'u.idusuario = uc.idusuario')
            ->where('uc.idcolegio', $idcolegio)
            ->where('uc.idrol', 3)
            ->orderBy('u.usuario', 'ASC')
            ->get()
            ->getResultArray();
    
        return view('gestionar_usuarios', ['lectores' => $lectores]);
    }
    
    

    // Agregar nuevo lector con contraseña aleatoria y token de recuperación
    public function agregarUsuario()
    {
        $data = $this->request->getPost();
        $email = strtolower(trim($data['email']));
        $usuario = $data['usuario'];
    
        // Verificar si el usuario está autenticado
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Debe iniciar sesión primero.');
            return redirect()->to('/login');
        }
    
        $idcolegio = session()->get('idcolegio');
    
        if (empty($idcolegio)) {
            log_message('error', 'ID del colegio no encontrado en la sesión.');
            session()->setFlashdata('error', 'El ID del colegio no está disponible.');
            return redirect()->to('/gestionar_usuarios');
        }
    
        $usuarioModel = new \App\Models\Usuario();
        $intermedioModel = new \App\Models\UsuarioColegioModel();
        $idrol = 3; // Lector
    
        // Buscar si ya existe un usuario con ese email
        $usuarioExistente = $usuarioModel->where('email', $email)->first();
    
        if ($usuarioExistente) {
            $idusuario = $usuarioExistente['idusuario'];
    
            // Verificar si ya está asociado al colegio con el rol
            $yaAsociado = $intermedioModel
                ->where('idusuario', $idusuario)
                ->where('idcolegio', $idcolegio)
                ->where('idrol', $idrol)
                ->first();
    
            if ($yaAsociado) {
                session()->setFlashdata('error', 'Este usuario ya está asociado a este colegio como lector.');
                return redirect()->to('/gestionar_usuarios');
            }
    
            // Asociar usuario existente al colegio
            $intermedioModel->insert([
                'idusuario' => $idusuario,
                'idcolegio' => $idcolegio,
                'idrol' => $idrol
            ]);
    
            // Enviar correo notificando que fue asociado como lector
            $this->_enviarCorreoAsociacionExistente($email, $usuario, $idcolegio);
    
            session()->setFlashdata('success', 'Usuario existente asociado correctamente al colegio como lector.');
            return redirect()->to('/gestionar_usuarios');
    
        } else {
            // Crear nuevo usuario
            $passwordTemporal = bin2hex(random_bytes(4));
            $hashedPassword = password_hash($passwordTemporal, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(50));
    
            $nuevoUsuario = [
                'usuario' => $usuario,
                'email' => $email,
                'password' => $hashedPassword,
                'token' => $token,
                'fecha_registro' => date('Y-m-d H:i:s')
            ];
    
            if (!$usuarioModel->insert($nuevoUsuario)) {
                session()->setFlashdata('error', 'No se pudo crear el nuevo usuario.');
                return redirect()->to('/gestionar_usuarios');
            }
    
            $idusuario = $usuarioModel->insertID();
    
            // Asociar nuevo usuario al colegio
            $intermedioModel->insert([
                'idusuario' => $idusuario,
                'idcolegio' => $idcolegio,
                'idrol' => $idrol
            ]);
    
            // Enviar correo para establecer contraseña
            $this->_enviarCorreoRecuperacionInicial($email, $usuario, $token, $idcolegio);
    
            session()->setFlashdata('success', 'Usuario creado correctamente y asociado como lector. Se envió el correo.');
            return redirect()->to('/gestionar_usuarios');
        }
    }
    
    

    
    // Eliminar usuario
    public function eliminarUsuario($idusuario)
    {
        $idcolegio = session()->get('idcolegio');
        if (empty($idcolegio)) {
            session()->setFlashdata('error', 'El ID del colegio no está disponible.');
            return redirect()->to('/gestionar_usuarios');
        }
    
        $intermedioModel = new \App\Models\UsuarioColegioModel();
    
        // Buscar la asociación con rol lector (idrol = 3)
        $asociacion = $intermedioModel
            ->where('idusuario', $idusuario)
            ->where('idcolegio', $idcolegio)
            ->where('idrol', 3)
            ->first();
    
        if ($asociacion) {
            if (!$intermedioModel->delete($asociacion['idusuario_colegio'])) {
                session()->setFlashdata('error', 'No se pudo desasociar al usuario del colegio.');
            } else {
                session()->setFlashdata('success', 'Usuario desasociado correctamente del colegio.');
            }
        } else {
            session()->setFlashdata('error', 'No se encontró una asociación válida con este colegio.');
        }
    
        return redirect()->to('/gestionar_usuarios');
    }
    

    // Método privado para enviar el correo
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
        <strong>Rol:</strong> Lector</p>
    
        <p>A partir de ahora podés acceder con tu email a este colegio con ese rol desde el sistema.</p>
    
        <p>Si esta acción no fue solicitada por vos o tenés alguna duda, por favor comunicate con el administrador del sistema.</p>
    
        <br>
        <p>Saludos,<br>
        <strong>Sistema de Gestión de Timbres</strong></p>
    ";
    
        $emailService->setMessage($mensaje);
    
        $emailService->send(); 
    }
 
public function editarUsuario($idusuario)
{
    $usuario = $this->Usuario->find($idusuario);

    if (!$usuario) {
        session()->setFlashdata('error', 'Usuario no encontrado.');
        return redirect()->to('/gestionar_usuarios');
    }

    return view('editar_usuario', ['usuario' => $usuario]);
}


public function actualizarUsuario()
{
    $data = $this->request->getPost();
    $id = $data['idusuario'];

    $usuarioExistente = $this->Usuario->find($id);

    if (!$usuarioExistente) {
        session()->setFlashdata('error', 'El usuario no existe.');
        return redirect()->to('/gestionar_usuarios');
    }

    $actualizado = [
       
        'email' => $data['email'],
    ];

    if ($this->Usuario->update($id, $actualizado)) {
        session()->setFlashdata('success', 'Usuario actualizado correctamente.');
    } else {
        session()->setFlashdata('error', 'No se pudo actualizar el usuario.');
    }

    return redirect()->to('/gestionar_usuarios');
}

}
