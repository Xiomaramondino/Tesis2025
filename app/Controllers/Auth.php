<?php


namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\Usuario;

class Auth extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('login');
    }

    public function login(){
        return view('login');
    }

    public function autenticar()
    {
        $session = session();
        $Usuario = new Usuario();
        
        $email = $this->request->getPost('email');
        $username = $this->request->getPost('usuario');
        $contrasenia = $this->request->getPost('password');
        $colegioSeleccionado = $this->request->getPost('idcolegio'); // Nuevo: lo que seleccionó el usuario
    
        // Buscar al usuario por nombre de usuario
        $user = $Usuario->where('usuario', $username)->first();
        
        if ($user && password_verify($contrasenia, $user['password'])) {
    
            // VALIDACIÓN DE COLEGIO
            if ($user['idcolegio'] != $colegioSeleccionado) {
                session()->set('error', 'El colegio seleccionado no coincide con el de registro');
                return redirect()->to('/login');
            }
    
            // Establecer datos de sesión si el colegio coincide
            session()->set([
                'username' => $user['usuario'],
                'logged_in' => true,
                'idrol' => $user['idrol'],
                'idturno' => $user['idturno'],
                'curso' => $user['curso'],
                'idcolegio' => $user['idcolegio'],
            ]);
    
            // Redirigir según el rol
            if ($user['idrol'] === '1') {
                return redirect()->to('/vista_admin');
            } elseif ($user['idrol'] === '2') {
                return redirect()->to('/gestionar_usuarios');
            } else {
                return redirect()->to('/horarios_lector');
            }
        } else {
            session()->set('error', 'Correo electrónico o contraseña incorrecta');
            return redirect()->to('/login');
        }
    }

    public function registro()
    {
        return view('registro');
        
    }

    public function guardarRegistro()
    {
        $session = \Config\Services::session();
        $usuarioModel = new Usuario();
    
        $usuario = $this->request->getPost('usuario');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $paymentStatus = $this->request->getPost('payment_status');
        $paypalOrderId = $this->request->getPost('paypal_order_id');
        $producto = $this->request->getPost('producto');
        $idcolegio = $this->request->getPost('idcolegio');


        // 1. Verificar que el pago se haya completado
        if ($paymentStatus !== 'completed' || empty($paypalOrderId)) {
            session()->set('error', 'Debes completar el proceso de pago primero');
            return redirect()->to('registro');
        }


        // Validación: Comprobar si algún campo está vacío
        if (empty($usuario) || empty($email) || empty($password)) {
            session()->set('error', 'Todos los campos son obligatorios');
            return redirect()->to('registro');
        }
    
        // Validación de usuario completo (solo letras)
        if (!preg_match('/^[a-zA-Z\s]+$/', $usuario)) {
            session()->set('error', 'El usuario solo puede contener letras.');
            return redirect()->to('registro');
        } 
        
        // Validar que la contraseña tenga al menos 6 caracteres, una mayúscula y un símbolo
        if (strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%*]/', $password)) {
            // Redirige a la vista para cambiar la contraseña
            session()->set('password_error', 'La  contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).');
            return redirect()->to('registro');
        }
        
        $array = [
            'usuario' => $usuario,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'payment_status' => $paymentStatus,
            'paypal_order_id' => $paypalOrderId,
            'producto' => $producto,
            'idcolegio' => $idcolegio,
            'idrol' => '1',  
            'fecha_registro' => date('Y-m-d H:i:s')
        ];
    
        if ($usuarioModel->insertarUsuario($array)) {
           
            
            session()->set('exito', '¡Registro y compra completados con éxito!');     
            return redirect()->to('login');   
        } else {
            session()->set('error', 'Ocurrió un error al registrar. Por favor intenta nuevamente.');
            return redirect()->to('registro');
        }

    }
    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

    public function recuperar_contrasena()
    {
        return view('recuperar_contrasena');
    }

    public function enviar_recuperacion()
    {
        $email = $this->request->getPost('email');
        $idusuario = $this->request->getPost('idusuario');
        $usuarioModel = new Usuario();

        $user = $usuarioModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(50));
            $usuarioModel->update($user['idusuario'], ['token' => $token]);

            $this->sendRecoveryEmail($email, $token);
            session()->setFlashdata('success', 'Se ha enviado un enlace de recuperación a tu correo.');
        } else {
            session()->setFlashdata('error', 'El correo no está registrado.');
        }

        return redirect()->to('recuperar_contrasena');
    }

    private function sendRecoveryEmail($email, $token)
    {
        $emailService = \Config\Services::email();

        $emailService->setFrom('timbreautomatico2025@gmail.com', 'Soporte de Timbre Automático');
        $emailService->setTo($email);
        $emailService->setSubject('Recuperación de contraseña');

        $link = base_url("resetear_contrasena?token=$token");
        $message = "Hola, <br> Para recuperar tu contraseña, haz clic en el siguiente enlace: <br><br>";
        $message .= "<a href='$link'>Recuperar contraseña</a><br><br>";
        $message .= "Si no solicitaste esta recuperación, ignora este correo.";

        $emailService->setMessage($message);
        $emailService->setMailType('html');

        if ($emailService->send()) {
            // Si el correo se envía correctamente
            log_message('info', 'Correo de recuperación enviado con éxito a ' . $email);
        } else {
            // Si hubo un error al enviar el correo
            log_message('error', 'Error al enviar correo de recuperación a ' . $email . ': ' . $emailService->printDebugger());
        }

    }

    public function resetear_contrasena()
    {
        $token = $this->request->getGet('token');
        $usuarioModel = new Usuario();
        $user = $usuarioModel->where('token', $token)->first();
    
        if (!$user) {
            return redirect()->to('resetear_contrasena')->with('error', 'Token inválido o expirado.');
        }
    
        return view('resetear_contrasena', [
            'token' => $token,
            'usuario' => $user['usuario'],
            'email' => $user['email']
        ]);
    }
    
    

    public function procesar_resetear_contrasena()
    {
        $token = $this->request->getPost('token');
        $nuevaContrasenia = $this->request->getPost('nueva_contrasenia');
       
        // Validar que la nueva contraseña tenga al menos 6 caracteres, una mayúscula y un símbolo
        if (strlen($nuevaContrasenia) < 6 || !preg_match('/[A-Z]/', $nuevaContrasenia) || !preg_match('/[!@#$%*]/', $nuevaContrasenia)) {
            session()->setFlashdata('password_error', 'La nueva contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).');
            return redirect()->to('resetear_contrasena?token=' . $token);
        }
    
        $usuarioModel = new Usuario();
        $user = $usuarioModel->where('token', $token)->first();
    
        if ($user) {
            $usuarioModel->update($user['idusuario'], [
                'password' => password_hash($nuevaContrasenia, PASSWORD_DEFAULT),
                'token' => null
            ]);
           
            session()->setFlashdata('success', 'Tu contraseña ha sido actualizada.');
            return redirect()->to('login');
        } else {
            session()->setFlashdata('error', 'El token es inválido o ha expirado.');
            return redirect()->to('recuperar_contrasena');
        }
    }
}

?>