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

    $username = $this->request->getPost('usuario');
    $contrasenia = $this->request->getPost('password'); 
    $colegioSeleccionado = $this->request->getPost('idcolegio');

    $user = $Usuario->where('usuario', $username)
                    ->where('idcolegio', $colegioSeleccionado)
                    ->first();

    if (!$user) {
        session()->setFlashdata('error', 'Alguno de los datos ingresados no es correcto.');
        return redirect()->to('/login');
    }

    if (!password_verify($contrasenia, $user['password'])) {
        session()->setFlashdata('error', 'Alguno de los datos ingresados no es correcto.');
        return redirect()->to('/login');
    }

    session()->set([
        'idusuario'  => $user['idusuario'],
        'username'   => $user['usuario'],
        'logged_in'  => true,
        'idrol'      => $user['idrol'],
        'idcolegio'  => $user['idcolegio'],
    ]);

    // Redirigir según el rol
     if ($user['idrol'] === '1') {
        return redirect()->to('/vista_admin');
    } elseif ($user['idrol'] === '2') {
        return redirect()->to('/gestionar_usuarios');
    } else {
        return redirect()->to('/horarios_lector');
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


        
        if ($paymentStatus !== 'completed' || empty($paypalOrderId)) {
            session()->set('error', 'Debes completar el proceso de pago primero');
            return redirect()->to('registro');
        }


        if (empty($usuario) || empty($email) || empty($password)) {
            session()->set('error', 'Todos los campos son obligatorios');
            return redirect()->to('registro');
        }
    
        if (!preg_match('/^[a-zA-Z\s]+$/', $usuario)) {
            session()->set('error', 'El usuario solo puede contener letras.');
            return redirect()->to('registro');
        } 
        
       
        if (strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%*]/', $password)) {
      
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
        $idcolegio = $this->request->getPost('idcolegio');
        $usuarioModel = new Usuario();
    
        // Buscar usuario con email + idcolegio
        $user = $usuarioModel
                    ->where('email', $email)
                    ->where('idcolegio', $idcolegio)
                    ->first();
    
        if ($user) {
            $token = bin2hex(random_bytes(50));
            $usuarioModel->update($user['idusuario'], ['token' => $token]);
    
            $this->sendRecoveryEmail($email, $token, $idcolegio); // pasa idcolegio
            session()->setFlashdata('success', 'Se ha enviado un enlace de recuperación a tu correo.');
        } else {
            session()->setFlashdata('error', 'No se encontró un usuario con ese correo e institución.');
        }
    
        return redirect()->to('recuperar_contrasena');
    }
    

    private function sendRecoveryEmail($email, $token, $idcolegio)
{
    $emailService = \Config\Services::email();

    $emailService->setFrom('timbreautomatico2025@gmail.com', 'Soporte de Timbre Automático');
    $emailService->setTo($email);
    $emailService->setSubject('Recuperación de contraseña');

    $link = base_url("resetear_contrasena?token=$token&idcolegio=$idcolegio");

    $message = "Hola, <br> Para recuperar tu contraseña, haz clic en el siguiente enlace: <br><br>";
    $message .= "<a href='$link'>Recuperar contraseña</a><br><br>";
    $message .= "Si no solicitaste esta recuperación, ignora este correo.";

    $emailService->setMessage($message);
    $emailService->setMailType('html');

    if ($emailService->send()) {
        log_message('info', 'Correo de recuperación enviado con éxito a ' . $email);
    } else {
        log_message('error', 'Error al enviar correo: ' . $emailService->printDebugger());
    }
}

public function resetear_contrasena()
{
    $token = $this->request->getGet('token');
    $idcolegio = $this->request->getGet('idcolegio');

    $usuarioModel = new Usuario();
    $user = $usuarioModel
                ->where('token', $token)
                ->where('idcolegio', $idcolegio)
                ->first();

                if (!$user) {
                    session()->setFlashdata('error', 'Token inválido o expirado.');
                    return redirect()->to('recuperar_contrasena');
                }
            

    return view('resetear_contrasena', [
        'token' => $token,
        'idcolegio' => $idcolegio,
        'usuario' => $user['usuario'],
        'email' => $user['email']
    ]);
}

public function procesar_resetear_contrasena()
{
    $token = $this->request->getPost('token');
    $idcolegio = $this->request->getPost('idcolegio');
    $nuevaContrasenia = $this->request->getPost('nueva_contrasenia');

    if (strlen($nuevaContrasenia) < 6 || !preg_match('/[A-Z]/', $nuevaContrasenia) || !preg_match('/[!@#$%*]/', $nuevaContrasenia)) {
        session()->setFlashdata('password_error', 'La nueva contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).');
        return redirect()->to('resetear_contrasena?token=' . $token . '&idcolegio=' . $idcolegio);
    }

    $usuarioModel = new Usuario();
    $user = $usuarioModel
                ->where('token', $token)
                ->where('idcolegio', $idcolegio)
                ->first();

    if ($user) {
        $usuarioModel->update($user['idusuario'], [
            'password' => password_hash($nuevaContrasenia, PASSWORD_DEFAULT),
            'token' => null
        ]);

        session()->setFlashdata('success', 'Tu contraseña ha sido actualizada.');
        return redirect()->to('login');
    } else {
        session()->setFlashdata('error', 'Token inválido o expirado.');
        return redirect()->to('recuperar_contrasena');
    }
}

}

?>