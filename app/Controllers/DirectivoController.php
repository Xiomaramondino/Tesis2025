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
        // Obtener directamente el idcolegio desde la sesión
        $idcolegio = session()->get('idcolegio');
    
        // Buscar usuarios lectores (idrol = 3) del mismo colegio
        $lectores = $this->Usuario
                         ->where('idrol', 3)
                         ->where('idcolegio', $idcolegio)
                         ->orderBy('usuario', 'ASC')
                         ->findAll();
    
        return view('gestionar_usuarios', ['lectores' => $lectores]);
    }
    
    

    // Agregar nuevo lector con contraseña aleatoria y token de recuperación
    public function agregarUsuario()
    {
        $data = $this->request->getPost();
        $email = $data['email'];
    
        // Verificar si el correo ya está registrado
        if ($this->Usuario->existenteEmail($email)) {
            session()->setFlashdata('error', 'El correo electrónico ya está registrado.');
            return redirect()->to('/gestionar_usuarios');
        }
    
        // Verificar si el usuario está autenticado
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Debe iniciar sesión primero.');
            return redirect()->to('/login');
        }
    
        // Obtener el idcolegio de la sesión (que corresponde al admin que está creando el usuario)
        $idcolegio = session()->get('idcolegio');  // Aquí estamos obteniendo el idcolegio de la sesión
        
        // Verificar si el idcolegio es válido (no vacío)
        if (empty($idcolegio)) {
            log_message('error', 'ID del colegio no encontrado en la sesión.');
            session()->setFlashdata('error', 'El ID del colegio no está disponible.');
            return redirect()->to('/gestionar_usuarios');
        }
    
        // Generar contraseña temporal
        $passwordTemporal = bin2hex(random_bytes(4)); // 8 caracteres
        $hashedPassword = password_hash($passwordTemporal, PASSWORD_DEFAULT);
    
        // Generar token de recuperación
        $token = bin2hex(random_bytes(50));
    
        // Datos del nuevo usuario
        $usuarioData = [
            'usuario' => $data['usuario'],
            'email' => $email,
            'password' => $hashedPassword,
            'curso' => $data['curso'],
            'idrol' => '3',
            'token' => $token,
            'idcolegio' => $idcolegio,  // Asignar el idcolegio del admin al nuevo usuario
            'fecha_registro' => date('Y-m-d H:i:s'),
        ];
    
        // Log para verificar los datos antes de la inserción
        log_message('info', 'Datos a insertar en el usuario: ' . json_encode($usuarioData));
    
        // Insertar usuario y enviar correo
        if ($this->Usuario->insert($usuarioData)) {
            $this->_enviarCorreoRecuperacionInicial($email, $data['usuario'], $token);
            session()->setFlashdata('success', 'Usuario creado correctamente. Se envió el correo.');
        } else {
            session()->setFlashdata('error', 'No se pudo agregar el usuario.');
        }
    
        return redirect()->to('/gestionar_usuarios');
    }
    

    
    // Eliminar usuario
    public function eliminarUsuario($idusuario)
    {
        $usuario = $this->Usuario->find($idusuario);

        if ($usuario) {
            $this->Usuario->delete($idusuario);
        } else {
            session()->setFlashdata('error', 'El usuario no existe.');
        }

        return redirect()->to('/gestionar_usuarios');
    }

    // Método privado para enviar el correo
    private function _enviarCorreoRecuperacionInicial($email, $usuario, $token)
    {
        $emailService = \Config\Services::email();

        $emailService->setFrom('timbreautomatico2025@gmail.com', 'Sistema de Gestión de Timbres');
        $emailService->setTo($email);
        $emailService->setSubject('Bienvenido - Establece tu contraseña');

        $link = base_url("resetear_contrasena?token=$token");

        $mensaje = "
            <h2>Hola $usuario,</h2>
            <p>Se ha creado una cuenta para vos en el <strong>Sistema de Gestión de Timbres</strong>.</p>
            <p>Tu nombre de usuario es: <strong>$usuario</strong></p>
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
    // Vista de edición de usuario
public function editarUsuario($idusuario)
{
    $usuario = $this->Usuario->find($idusuario);

    if (!$usuario) {
        session()->setFlashdata('error', 'Usuario no encontrado.');
        return redirect()->to('/gestionar_usuarios');
    }

    return view('editar_usuario', ['usuario' => $usuario]);
}

// Guardar cambios del usuario
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
        'usuario' => $data['usuario'],
        'email' => $data['email'],
        'curso' => $data['curso'],
    ];

    if ($this->Usuario->update($id, $actualizado)) {
        session()->setFlashdata('success', 'Usuario actualizado correctamente.');
    } else {
        session()->setFlashdata('error', 'No se pudo actualizar el usuario.');
    }

    return redirect()->to('/gestionar_usuarios');
}

}
