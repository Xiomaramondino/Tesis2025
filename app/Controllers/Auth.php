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
            'email'     => $user['email'],
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
        if ($idrol == 1) { // Admin
            $cursoModel = new \App\Models\CursoModel();
            $idcolegio = session()->get('idcolegio');
        
            $hayCursos = $cursoModel->where('idcolegio', $idcolegio)->countAllResults();
        
            if ($hayCursos == 0) {
                // Si no hay cursos cargados, primer setup
                return redirect()->to('/cursos?setup=1');
            } else {
                return redirect()->to('/vista_admin');
            }
        }elseif ($idrol == 2) { // Directivo
            return redirect()->to('/gestionar_usuarios');
        } elseif ($idrol == 4) { // Profesor
            return redirect()->to('/profesor/avisos'); // <-- nueva vista de calendario
        } else { // Alumno u otro rol
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

public function mostrarOpcionesCambio()
{
    $session = session();
    if (!$session->has('idusuario')) {
        return redirect()->to('/login'); // seguridad
    }

    $idusuario = $session->get('idusuario');

    $db = \Config\Database::connect();
    $builder = $db->table('usuario_colegio uc');
    $builder->select('uc.idcolegio, uc.idrol, c.nombre as colegio, r.tipo as rol');
    $builder->join('colegios c', 'c.idcolegio = uc.idcolegio');
    $builder->join('rol r', 'r.idrol = uc.idrol');
    $builder->where('uc.idusuario', $idusuario);
    $result = $builder->get()->getResultArray();

    return view('cambiar_colegio', ['opciones' => $result]);
}

public function cambiarContexto()
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
    $solicitudModel = new \App\Models\SolicitudAdminModel(); 

    $usuario = $this->request->getPost('usuario');
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $paymentStatus = $this->request->getPost('payment_status');
    $paypalOrderId = $this->request->getPost('paypal_order_id');
    $producto = $this->request->getPost('producto');
    $idcolegio = $this->request->getPost('idcolegio');
    $cantidad = (int)$this->request->getPost('cantidad'); 
    $idrol = 1; 

    // Validaciones básicas
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

    if ($cantidad < 1 || $cantidad > 5) {
        session()->set('error', 'La cantidad de dispositivos debe ser entre 1 y 5.');
        return redirect()->to('registro');
    }

    //  Buscar usuario y admin del colegio
    $usuarioExistente = $usuarioModel->where('email', $email)->first();
    $adminExistente = $usuarioColegioModel
        ->where('idcolegio', $idcolegio)
        ->where('idrol', 1)
        ->first();
    // CASO 1: El usuario ya existe
    if ($usuarioExistente) {
        $idusuario = $usuarioExistente['idusuario'];

        // Verificar si ya está asociado al colegio
        $yaAsociado = $usuarioColegioModel
            ->where('idusuario', $idusuario)
            ->where('idcolegio', $idcolegio)
            ->first();

        if ($yaAsociado) {
            // Si ya es admin del colegio → crear solicitud pendiente (compra adicional)
            if ($yaAsociado['idrol'] == 1) {
                $solicitudModel->insert([
                    'idusuario' => $idusuario,
                    'idcolegio' => $idcolegio,
                    'cantidad' => $cantidad,
                    'producto' => $producto,
                    'paypal_order_id' => $paypalOrderId,
                    'payment_status' => $paymentStatus,
                    'estado' => 'pendiente'
                ]);
        session()->setFlashdata('success', 'Tu solicitud de compra adicional ha sido enviada para revisión. Debe ser aprobada por el administrador antes de continuar.');
        return redirect()->to(base_url('/'));
            }else {
                // Ya tiene otro rol (por ejemplo, lector o directivo)
                session()->set('error', 'Este correo ya está registrado en esta institución con otro rol. Iniciá sesión con tu cuenta.');
                return redirect()->to('login');
            }
        } else {
            // Si no está asociado a ese colegio
            if (!$adminExistente) {
                // Primer usuario del colegio → admin automático
                $usuarioColegioModel->insert([
                    'idusuario' => $idusuario,
                    'idcolegio' => $idcolegio,
                    'idrol' => $idrol,
                    'total_comprados' => $cantidad
                ]);
                session()->setFlashdata('success', 'Ahora estás asociado como admin de esta institución.');
                return redirect()->to('login');
            } else {
                // Ya hay admin → crear solicitud pendiente
                $solicitudModel->insert([
                    'idusuario' => $idusuario,
                    'idcolegio' => $idcolegio,
                    'cantidad' => $cantidad,
                    'producto' => $producto,
                    'paypal_order_id' => $paypalOrderId,
                    'payment_status' => $paymentStatus,
                    'estado' => 'pendiente'
                ]);

                session()->setFlashdata('success', 'Se ha enviado una solicitud al admin del colegio para aprobación.');
                return redirect()->to('registro');
            }
        }
    }
    // CASO 2: El usuario NO existe → crear nuevo usuario
    $nuevoUsuario = [
        'usuario' => $usuario,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'payment_status' => $paymentStatus,
        'paypal_order_id' => $paypalOrderId,
        'producto' => $producto,
        'fecha_registro' => date('Y-m-d H:i:s')
    ];

    if ($usuarioModel->insert($nuevoUsuario)) {
        $idusuario = $usuarioModel->insertID();

        if (!$adminExistente) {
      
            $usuarioColegioModel->insert([
                'idusuario' => $idusuario,
                'idcolegio' => $idcolegio,
                'idrol' => $idrol,
                'total_comprados' => $cantidad
            ]);
            session()->set('exito', '¡Registro y compra completados con éxito! Ahora eres admin de la institución.');
            return redirect()->to('login');
        } else {
         
            $solicitudModel->insert([
                'idusuario' => $idusuario,
                'idcolegio' => $idcolegio,
                'cantidad' => $cantidad,
                'producto' => $producto,
                'paypal_order_id' => $paypalOrderId,
                'payment_status' => $paymentStatus,
                'estado' => 'pendiente'
            ]);

            session()->setFlashdata('success', '¡Registro completado! Se ha enviado una solicitud al admin para aprobación.');
            return redirect()->to('registro');
        }
    } else {
        session()->set('error', 'Ocurrió un error al registrar el usuario. Intenta nuevamente.');
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
    $usuarioModel = new Usuario();

    // Buscar usuario solo por email
    $user = $usuarioModel
                ->where('email', $email)
                ->first();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $usuarioModel->update($user['idusuario'], ['token' => $token]);

        $this->sendRecoveryEmail($email, $token); // ya no pasa idcolegio
        session()->setFlashdata('success', 'Se ha enviado un enlace de recuperación a tu correo.');
    } else {
        session()->setFlashdata('error', 'No se encontró un usuario con ese correo.');
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
        log_message('info', 'Correo de recuperación enviado con éxito a ' . $email);
    } else {
        log_message('error', 'Error al enviar correo: ' . $emailService->printDebugger());
    }
}

public function resetear_contrasena()
{
    $token = $this->request->getGet('token');

    $usuarioModel = new Usuario();
    $user = $usuarioModel
                ->where('token', $token)
                ->first();

    if (!$user) {
        session()->setFlashdata('error', 'Token inválido o expirado.');
        return redirect()->to('recuperar_contrasena');
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

    if (strlen($nuevaContrasenia) < 6 || !preg_match('/[A-Z]/', $nuevaContrasenia) || !preg_match('/[!@#$%*]/', $nuevaContrasenia)) {
        session()->setFlashdata('password_error', 'La nueva contraseña debe tener al menos 6 caracteres, una letra mayúscula y un símbolo (!@#$%).');
        return redirect()->to('resetear_contrasena?token=' . $token);
    }

    $usuarioModel = new Usuario();
    $user = $usuarioModel
                ->where('token', $token)
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