<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuario;
use App\Models\DispositivoModel; 

class AdminController extends Controller
{
    public function index()
    {
        // Verificar que el usuario tenga el rol de admin
        if (session()->get('idrol') !== '1') {
            return redirect()->to('/login');
        }

        $idcolegio = session()->get('idcolegio'); // Obtener el colegio del admin

        // Obtener usuarios directivos del mismo colegio
        $usuarioModel = new Usuario();
        $usuarios_directivos = $usuarioModel
            ->where('idrol', '2')
            ->where('idcolegio', $idcolegio)
            ->orderBy('usuario', 'ASC')
            ->findAll();

        // Obtener lectores del mismo colegio
        $lectores = $usuarioModel
            ->where('idrol', '3')
            ->where('idcolegio', $idcolegio)
            ->orderBy('usuario', 'ASC')
            ->findAll();

        return view('vista_admin', [
            'usuarios_directivos' => $usuarios_directivos,
            'lectores' => $lectores
        ]);
    }

    public function guardarUsuario()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        // Verificar que el usuario tenga el rol de admin
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
        
        $model = new \App\Models\Usuario();
        $usuarioExistente = $model->where('email', $email)->first();
        
        if ($usuarioExistente) {
            session()->setFlashdata('error', 'El email ingresado ya está en uso por otro usuario.');
            return redirect()->to('/vista_admin');
        }

        $passwordTemporal = bin2hex(random_bytes(4));
        $hashedPassword = password_hash($passwordTemporal, PASSWORD_DEFAULT);

        $token = bin2hex(random_bytes(50));

        $data = [
            'usuario' => $usuario,
            'email' => $email,
            'password' => $hashedPassword,
            'idrol' => '2',
            'fecha_registro' => date('Y-m-d H:i:s'),
            'token' => $token,
            'idcolegio' => $idcolegio,
        ];

        if ($model->insertarUsuario($data)) {
            $this->_enviarCorreoRecuperacionInicial($email, $usuario, $token, $idcolegio);
            session()->setFlashdata('success', 'Usuario creado correctamente y se envió el correo.');
        } else {
            session()->setFlashdata('error', 'Ocurrió un error al agregar el usuario.');
        }

        return redirect()->to('/vista_admin');
    }

    public function eliminarDirectivo($idusuario)
    {
        $usuarioModel = new Usuario();

        $usuario = $usuarioModel->find($idusuario);
        if ($usuario && $usuario['idrol'] === '2') {
            if (!$usuarioModel->delete($idusuario)) {
                session()->setFlashdata('error', 'Hubo un error al eliminar al directivo.');
            }
        } else {
            session()->setFlashdata('error', 'El usuario no es un directivo o no existe.');
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
    
    public function registrar_dispositivo()
{
    return view('registrar_dispositivo');
}

public function guardar_dispositivo()
{
    $mac = $this->request->getPost('mac');
    $idusuario = session()->get('idusuario');
    $idcolegio = session()->get('idcolegio');


    if (!preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $mac)) {
        return redirect()->back()->with('error', 'La dirección MAC no tiene un formato válido.');
    }

    // Validación de duplicado
    $dispositivoModel = new \App\Models\DispositivoModel();
    $existe = $dispositivoModel
                ->where('mac', $mac)
                ->where('idusuario', $idusuario)
                ->where('idcolegio', $idcolegio)
                ->first();

    if ($existe) {
        return redirect()->back()->with('error', 'Esta MAC ya está registrada para tu usuario y colegio.');
    }

    $dispositivoModel->insert([
        'mac' => $mac,
        'idusuario' => $idusuario,
        'idcolegio' => $idcolegio
    ]);

    return redirect()->to('registrar_dispositivo')->with('success', 'Dispositivo registrado con éxito.');
}
}
