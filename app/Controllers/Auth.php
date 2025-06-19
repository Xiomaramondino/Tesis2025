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
    
        $email = strtolower(trim($this->request->getPost('email')));
        $contrasenia = $this->request->getPost('password');
    
        $user = $Usuario->where('email', $email)->first();
    
        if (!$user || !password_verify($contrasenia, $user['password'])) {
            session()->setFlashdata('error', 'Alguno de los datos ingresados no es correcto.');
            return redirect()->to('/login');
        }
    
        // Guardar sesión básica sin contexto aún
        $session->set([
            'idusuario' => $user['idusuario'],
            'username'  => $user['usuario'],
            'logged_in' => true
        ]);
    
        // Buscar colegios y roles del usuario
        $db = \Config\Database::connect();
        $builder = $db->table('usuario_colegio uc');
        $builder->select('uc.idcolegio, uc.idrol, c.nombre as colegio, r.tipo as rol');
        $builder->join('colegios c', 'c.idcolegio = uc.idcolegio');
        $builder->join('rol r', 'r.idrol = uc.idrol');
        $builder->where('uc.idusuario', $user['idusuario']);
        $result = $builder->get()->getResultArray();
    
        
        return view('seleccionar_colegio', ['opciones' => $result]);
    }

    private function redirigirPorRol($idrol)
{
    if ($idrol == 1) {
        return redirect()->to('/vista_admin');
    } elseif ($idrol == 2) {
        return redirect()->to('/gestionar_usuarios');
    } else {
        return redirect()->to('/horarios_lector');
    }
}

    public function seleccionarContexto()
{
    $session = session();
    $valor = $this->request->getPost('idcolegio');

    list($idcolegio, $idrol) = explode('-', $valor);

    $session->set([
        'idcolegio' => $idcolegio,
        'idrol'     => $idrol
    ]);

    return $this->redirigirPorRol($idrol);
}


    public function registro()
    {
        return view('registro');
        
    }

    public function guardarRegistro()
    {
        $session = \Config\Services::session();
        $usuarioModel = new \App\Models\Usuario();
        $usuarioColegioModel = new \App\Models\UsuarioColegioModel();
    
        $usuario = $this->request->getPost('usuario');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $paymentStatus = $this->request->getPost('payment_status');
        $paypalOrderId = $this->request->getPost('paypal_order_id');
        $producto = $this->request->getPost('producto');
        $idcolegio = $this->request->getPost('idcolegio');
        $idrol = 1; // Siempre se guarda en la tabla intermedia
    
        // Validaciones
        if ($paymentStatus !== 'completed' || empty($paypalOrderId)) {
            session()->set('error', 'Debes completar el proceso de pago primero.');
            return redirect()->to('registro');
        }
    
        if (empty($usuario) || empty($email) || empty($password)) {
            session()->set('error', 'Todos los campos son obligatorios.');
            return redirect()->to('registro');
        }
    
        if (!preg_match('/^[a-zA-Z\s]+$/', $usuario)) {
            session()->set('error', 'El nombre de usuario solo puede contener letras.');
            return redirect()->to('registro');
        }
    
        if (strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%*]/', $password)) {
            session()->set('password_error', 'La contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).');
            return redirect()->to('registro');
        }
    
        // Buscar usuario por email
        $usuarioExistente = $usuarioModel->where('email', $email)->first();
    
        if ($usuarioExistente) {
            $idusuario = $usuarioExistente['idusuario'];
    
            // Verificar si ya está asociado con ese colegio y ese mismo rol
            $yaAsociado = $usuarioColegioModel
                ->where('idusuario', $idusuario)
                ->where('idcolegio', $idcolegio)
                ->where('idrol', $idrol)
                ->first();
    
            if ($yaAsociado) {
                session()->set('error', 'Este correo ya tiene una cuenta registrada en esta institución con ese rol. Iniciá sesión con tu cuenta.');
                return redirect()->to('login');
            } else {
                // Asociar nuevo colegio y rol
                $usuarioColegioModel->insert([
                    'idusuario' => $idusuario,
                    'idcolegio' => $idcolegio,
                    'idrol' => $idrol
                ]);
    
                session()->setFlashdata('success', 'Ya tenías una cuenta y ahora también estás asociado a esta institución con el nuevo rol.');
                return redirect()->to('login');
            }
        } else {
            // Crear nuevo usuario
            $nuevoUsuario = [
                'usuario' => $usuario,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'payment_status' => $paymentStatus,
                'paypal_order_id' => $paypalOrderId,
                'producto' => $producto,
                'idrol' => $idrol, // por compatibilidad, aunque el rol real va en la intermedia
                'fecha_registro' => date('Y-m-d H:i:s')
            ];
    
            if ($usuarioModel->insert($nuevoUsuario)) {
                $idusuario = $usuarioModel->insertID();
    
                // Crear la asociación en usuario_colegio
                $usuarioColegioModel->insert([
                    'idusuario' => $idusuario,
                    'idcolegio' => $idcolegio,
                    'idrol' => $idrol
                ]);
    
                session()->set('exito', '¡Registro y compra completados con éxito!');
                return redirect()->to('login');
            } else {
                session()->set('error', 'Ocurrió un error al registrar el usuario. Intenta nuevamente.');
                return redirect()->to('registro');
            }
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