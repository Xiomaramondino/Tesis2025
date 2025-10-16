<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuario;
use App\Models\ColegioModel;
use App\Models\UsuarioColegioModel;
use App\Models\DispositivoModel; 

class AdminController extends Controller
{
public function index()
{
    if (session()->get('idrol') !== '1') {
        return redirect()->to('/login');
    }

    $idcolegio = session()->get('idcolegio');
    $db = \Config\Database::connect();

    // Directivos
    $queryDirectivos = $db->table('usuario_colegio uc')
        ->select('u.idusuario, u.usuario, u.email')
        ->join('usuarios u', 'u.idusuario = uc.idusuario')
        ->where('uc.idcolegio', $idcolegio)
        ->where('uc.idrol', 2)
        ->orderBy('u.usuario', 'ASC')
        ->get();

    $usuarios_directivos = $queryDirectivos->getResultArray();

    // Profesores
    $queryProfesores = $db->table('usuario_colegio uc')
        ->select('u.idusuario, u.usuario, u.email')
        ->join('usuarios u', 'u.idusuario = uc.idusuario')
        ->where('uc.idcolegio', $idcolegio)
        ->where('uc.idrol', 4)
        ->orderBy('u.usuario', 'ASC')
        ->get();

    $usuarios_profesores = $queryProfesores->getResultArray();

    //Contar solicitudes pendientes
    $solicitudModel = new \App\Models\SolicitudAdminModel();
    $solicitudesPendientes = count($solicitudModel->obtenerPendientesPorColegio($idcolegio));

    return view('vista_admin', [
        'usuarios_directivos' => $usuarios_directivos,
        'usuarios_profesores' => $usuarios_profesores,
        'solicitudesPendientes' => $solicitudesPendientes
    ]);
}
    
    public function guardarUsuario()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
    
        if (session()->get('idrol') !== '1') {
            return redirect()->to('/login');
        }
    
        $idcolegio = session()->get('idcolegio');
        if (empty($idcolegio)) {
            session()->setFlashdata('error', 'El ID del colegio no está disponible.');
            return redirect()->to('/vista_admin');
        }
    
        $db = \Config\Database::connect();
        $dispositivo = $db->table('dispositivo') 
            ->where('idcolegio', $idcolegio)
            ->get()
            ->getRow();
    
        if (!$dispositivo) {
            session()->setFlashdata('error', 'Este colegio no tiene un dispositivo (MAC) registrado. Registre un dispositivo antes de agregar usuarios.');
            return redirect()->to('/vista_admin');
        }
    
        $usuario = $this->request->getPost('usuario');
        $email = strtolower(trim($this->request->getPost('email')));
        $idrol = (int) $this->request->getPost('tipo_usuario');
    
        if (empty($usuario) || empty($email) || empty($idrol)) {
            session()->setFlashdata('error', 'Todos los campos son obligatorios.');
            return redirect()->to('/vista_admin');
        }
    
        // Definir texto del tipo de usuario para correos
        $tipoUsuario = match($idrol) {
            2 => 'Directivo',
            4 => 'Profesor',
            default => 'Usuario'
        };
    
        $usuarioModel = new \App\Models\Usuario();
        $intermedioModel = new \App\Models\UsuarioColegioModel(); 
        $emailSolicitante = session()->get('email'); 
    
        $usuarioExistente = $usuarioModel->where('email', $email)->first();
    
        if ($usuarioExistente) {
            $idusuario = $usuarioExistente['idusuario'];
    
            // Verificar si ya está asociado con ese colegio y rol
            $existeAsociacion = $intermedioModel
                ->where('idusuario', $idusuario)
                ->where('idcolegio', $idcolegio)
                ->where('idrol', $idrol)
                ->first();
    
            if ($existeAsociacion) {
                session()->setFlashdata('error', "Este usuario ya está asociado a este colegio como $tipoUsuario.");
                return redirect()->to('/vista_admin');
            }
    
            // Verificar si ya existe una solicitud pendiente
            $solicitudPendiente = $db->table('solicitudes_asociacion')
                ->where('idusuario', $idusuario)
                ->where('idcolegio', $idcolegio)
                ->where('idrol', $idrol)
                ->where('estado', 'pendiente')
                ->get()
                ->getRow();
    
            if ($solicitudPendiente) {
                session()->setFlashdata('error', "Ya existe una solicitud pendiente para este usuario como $tipoUsuario en este colegio.");
                return redirect()->to('/vista_admin');
            }
    
            // Crear nueva solicitud
            $token = bin2hex(random_bytes(32));
    
            $db->table('solicitudes_asociacion')->insert([
                'idusuario' => $idusuario,
                'idcolegio' => $idcolegio,
                'idrol' => $idrol,
                'token' => $token,
                'estado' => 'pendiente',
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'email_solicitante' => $emailSolicitante 
            ]);
    
            $this->_enviarCorreoSolicitudAsociacion($email, $usuarioExistente['usuario'], $token, $idcolegio, $tipoUsuario);
    
            session()->setFlashdata('success', "Solicitud de asociación enviada al correo del usuario como $tipoUsuario.");
            return redirect()->to('/vista_admin');
        }
    
        // Antes de crear nuevo usuario, asegurarse que no haya asociación previa
        $usuarioConAsociacion = $usuarioModel->select('usuarios.idusuario')
            ->join('usuario_colegio', 'usuarios.idusuario = usuario_colegio.idusuario')
            ->where('usuarios.email', $email)
            ->where('usuario_colegio.idcolegio', $idcolegio)
            ->where('usuario_colegio.idrol', $rol)
            ->first();
    
        if ($usuarioConAsociacion) {
            session()->setFlashdata('error', "Ya existe un usuario con este correo asociado a este colegio como $tipoUsuario.");
            return redirect()->to('/vista_admin');
        }
    
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
    
        if (!$idusuario) {
            session()->setFlashdata('error', 'No se pudo obtener el ID del nuevo usuario.');
            return redirect()->to('/vista_admin');
        }
    
        // Crear solicitud de asociación
        $db->table('solicitudes_asociacion')->insert([
            'idusuario' => $idusuario,
            'idcolegio' => $idcolegio,
            'idrol' => $rol,
            'token' => $token,
            'estado' => 'pendiente',
            'fecha_creacion' => date('Y-m-d H:i:s'),
            'email_solicitante' => $emailSolicitante
        ]);
    
        $this->_enviarCorreoSolicitudAsociacion($email, $usuario, $token, $idcolegio, $tipoUsuario);
    
        session()->setFlashdata('success', "Usuario creado. Se envió una solicitud de asociación al correo como $tipoUsuario.");
        return redirect()->to('/vista_admin');
    }
       
    private function _enviarCorreoSolicitudAsociacion($email, $usuario, $token, $idcolegio, $tipoUsuario)
    {
        $colegioModel = new \App\Models\ColegioModel();
        $colegio = $colegioModel->find($idcolegio);
        $nombreColegio = $colegio ? $colegio['nombre'] : 'un colegio';
    
        $emailService = \Config\Services::email();
    
        $emailService->setFrom('timbreautomatico2025@gmail.com', 'Sistema de Gestión de Timbres');
        $emailService->setTo($email);
        $emailService->setSubject("Solicitud de asociación como $tipoUsuario");
    
        $linkAceptar = base_url("admin/confirmarAsociacion/$token/aceptar");
        $linkRechazar = base_url("admin/confirmarAsociacion/$token/rechazar");
    
        $mensaje = "
            <h2>Hola {$usuario},</h2>
            <p>Te invitaron a asociarte como <strong>{$tipoUsuario}</strong> al siguiente colegio:</p>
            <p><strong>Colegio:</strong> {$nombreColegio}</p>
            <p>Por favor, confirmá si aceptás esta asociación:</p>
            <p>
                <a href='{$linkAceptar}' style='padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Aceptar</a>
                &nbsp;
                <a href='{$linkRechazar}' style='padding: 10px 20px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;'>Rechazar</a>
            </p>
            <p>Si no reconocés este colegio o no querés asociarte, simplemente rechazá la solicitud.</p>
            <br>
            <p>Saludos,<br>Equipo del Sistema de Gestión de Timbres</p>
        ";
    
        $emailService->setMessage($mensaje);
        $emailService->setMailType('html');
    
        if (!$emailService->send()) {
            log_message('error', 'Error al enviar el correo de solicitud de asociación a ' . $email);
        }
    }
    
    private function _enviarCorreoConfirmacionAsociacion($email, $usuario, $token, $idcolegio, $esUsuarioNuevo)
    {
        $colegioModel = new ColegioModel();
        $colegio = $colegioModel->find($idcolegio);
        $nombreColegio = $colegio ? $colegio['nombre'] : 'un colegio';

        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Confirmación de asociación a colegio');

        $aceptar = base_url("admin/confirmarAsociacion/$token/aceptar");
        $rechazar = base_url("admin/confirmarAsociacion/$token/rechazar");

        $mensaje = "
            <h2>Hola $usuario,</h2>
            <p>Se te ha invitado a ser directivo en el colegio <strong>$nombreColegio</strong>.</p>
            <p>Por favor, confirmá o rechazá esta solicitud:</p>
            <p><a href='$aceptar'>Aceptar Asociación</a> | <a href='$rechazar'>Rechazar Asociación</a></p>
            <p>Este enlace caduca en 48 horas.</p>
        ";

        $emailService->setMessage($mensaje);
        $emailService->setMailType('html');
        $emailService->send();
    }

    public function confirmarAsociacion($token, $accion)
{
    $db = \Config\Database::connect();
    $solicitud = $db->table('solicitudes_asociacion')
                    ->where('token', $token)
                    ->where('estado', 'pendiente')
                    ->get()
                    ->getRow();

    if (!$solicitud) {
        return view('mensaje', ['mensaje' => 'Solicitud inválida o expirada.']);
    }

    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->find($solicitud->idusuario);
    $intermedioModel = new UsuarioColegioModel();

    $solicitanteEmail = $solicitud->email_solicitante; 

    if ($accion === 'aceptar') {
        // Asociar el usuario al colegio
        $intermedioModel->insert([
            'idusuario' => $solicitud->idusuario,
            'idcolegio' => $solicitud->idcolegio,
            'idrol' => $solicitud->idrol,
        ]);

        // Borrar la solicitud
        $db->table('solicitudes_asociacion')->where('id', $solicitud->id)->delete();

        // Notificar al solicitante
        $this->_enviarCorreoNotificacionSolicitante($solicitanteEmail, $usuario['usuario'], true);

        // Enviar correo al usuario según su estado (nuevo o existente)
        if (empty($usuario['token'])) {
            $this->_enviarCorreoAsociacionExistente($usuario['email'], $usuario['usuario'], $solicitud->idcolegio);

            return view('mensaje', [
                'mensaje' => 'Asociación confirmada. Ya podés usar tu cuenta.',
                'esNuevo' => false,
                'email' => $usuario['email']
            ]);
        } else {
            $this->_enviarCorreoRecuperacionInicial($usuario['email'], $usuario['usuario'], $usuario['token'], $solicitud->idcolegio);

            return view('mensaje', [
                'mensaje' => 'Asociación confirmada. Te enviamos un correo para que establezcas tu contraseña.',
                'esNuevo' => true,
                'email' => $usuario['email']
            ]);
        }

    } else {
        // Rechazada: eliminar solicitud y notificar al solicitante
        $db->table('solicitudes_asociacion')->where('id', $solicitud->id)->delete();

        $this->_enviarCorreoNotificacionSolicitante($solicitanteEmail, $usuario['usuario'], false);

        return view('mensaje', [
            'mensaje' => 'Rechazaste la asociación. La solicitud fue eliminada.',
            'rechazado' => true,
            'email' => $usuario['email']
        ]);
    }
}

private function _enviarCorreoNotificacionSolicitante($emailSolicitante, $nombreUsuario, $aceptado)
{
    $email = \Config\Services::email();
    $email->setTo($emailSolicitante);
    $email->setSubject('Notificación sobre la solicitud de asociación');

    if ($aceptado) {
        $mensaje = "El usuario <strong>$nombreUsuario</strong> ha <strong>aceptado</strong> tu solicitud de asociación al colegio.";
    } else {
        $mensaje = "El usuario <strong>$nombreUsuario</strong> ha <strong>rechazado</strong> tu solicitud de asociación al colegio.";
    }

    $email->setMessage($mensaje);
    $email->setMailType('html'); 
    $email->send();
}


    public function eliminarSolicitudesExpiradas()
    {
        $db = \Config\Database::connect();
        $limite = date('Y-m-d H:i:s', strtotime('-48 hours'));

        $db->table('solicitudes_asociacion')
            ->where('estado', 'pendiente')
            ->where('fecha_solicitud <', $limite)
            ->delete();
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
        $idusuario = $this->request->getPost('idusuario');
        $usuarioModel = new Usuario();
    
        // Datos actuales del usuario
        $usuarioActual = $usuarioModel->find($idusuario);
    
        // Datos nuevos (normalizados)
        $nuevoUsuario = trim($this->request->getPost('usuario'));
        $nuevoEmail   = strtolower(trim($this->request->getPost('email')));
    
        $cambios = [];
        $mensajeCambios = [];
    
        // Comparación de usuario
        if ($usuarioActual['usuario'] !== $nuevoUsuario) {
            $cambios['usuario'] = $nuevoUsuario;
            $mensajeCambios[] = "Nombre de usuario modificado.";
        }
    
        // Comparación de email
        if (strtolower($usuarioActual['email']) !== $nuevoEmail) {
            $cambios['email'] = $nuevoEmail;
            $mensajeCambios[] = "Correo electrónico actualizado.";
        }
    
        if (!empty($cambios)) {
            // Guardar cambios
            $usuarioModel->update($idusuario, $cambios);
    
            // Construir mensaje para el correo
            $detalleCambios = implode(" ", $mensajeCambios);
    
            // Enviar notificación por mail
            $this->_enviarCorreoEdicionUsuario(
                $cambios['email'] ?? $usuarioActual['email'], // si no cambió el mail, uso el viejo
                $cambios['usuario'] ?? $usuarioActual['usuario'],
                $detalleCambios
            );
    
            // Flashdata de éxito
            session()->setFlashdata('success', 'Datos actualizados correctamente. ' . $detalleCambios);
        } else {
            // Ningún cambio detectado
            session()->setFlashdata('info', 'No se detectaron cambios en los datos.');
        }
    
        return redirect()->to('/vista_admin');
    }
    

    // 📧 Notificación de cambios por correo
    private function _enviarCorreoEdicionUsuario($email, $usuario, $detalleCambios)
    {
        $emailService = \Config\Services::email();
    
        $emailService->setFrom('timbreautomatico2025@gmail.com', 'Sistema de Gestión de Timbres');
        $emailService->setTo($email);
        $emailService->setSubject('Actualización de tu cuenta');
    
        $mensaje = "
            <h2>Hola {$usuario},</h2>
            <p>Tu cuenta en el <strong>Sistema de Gestión de Timbres</strong> fue actualizada por un administrador.</p>
            <p><strong>Cambios realizados:</strong> {$detalleCambios}</p>
            <p><strong>Nombre de usuario:</strong> {$usuario}</p>
            <p><strong>Correo electrónico:</strong> {$email}</p>
            <p>Si no reconocés esta acción, por favor contactá al administrador del sistema.</p>
            <br>
            <p>Saludos,<br>
            <strong>Sistema de Gestión de Timbres</strong></p>
        ";
    
        $emailService->setMessage($mensaje);
        $emailService->setMailType('html');
        $emailService->send();
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

    $emailService->send(); 
}

public function registrar_dispositivo()
{
    $session = session();
    $idusuario = $session->get('idusuario');
    $idcolegio = $session->get('idcolegio');

    if (!$idusuario) {
        return redirect()->to('/login')->with('error', 'Sesión no iniciada.');
    }

    $dispositivoModel = new DispositivoModel();
    $usuarioColegioModel = new \App\Models\UsuarioColegioModel();

    // Dispositivos ya registrados
    $mis_dispositivos = $dispositivoModel->getDispositivosConColegio($idusuario);

    // Obtener la cantidad total comprada desde usuario_colegio
    $usuarioColegio = $usuarioColegioModel
        ->where('idusuario', $idusuario)
        ->where('idcolegio', $idcolegio)
        ->first();

    $totalComprados = $usuarioColegio['total_comprados'] ?? 0;
    $totalRegistrados = count($mis_dispositivos);
    $pendientes = max(0, $totalComprados - $totalRegistrados);

    return view('registrar_dispositivo', [
        'mis_dispositivos' => $mis_dispositivos,
        'totalComprados' => $totalComprados,
        'totalRegistrados' => $totalRegistrados,
        'pendientes' => $pendientes
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

public function editarProfesor($idusuario)
{
    $usuarioModel = new \App\Models\Usuario();
    $usuario = $usuarioModel->find($idusuario);

    if (!$usuario) {
        session()->setFlashdata('error', 'Usuario no encontrado');
        return redirect()->to('/vista_admin');
    }

    return view('editar_profesor', [
        'usuario' => $usuario
    ]);
}

public function actualizarProfesor($idusuario)
{
    $usuarioModel = new \App\Models\Usuario();

    $usuarioActual = $usuarioModel->find($idusuario);

    if (!$usuarioActual) {
        session()->setFlashdata('error', 'Usuario no encontrado.');
        return redirect()->to('/vista_admin');
    }

    // Obtener datos del formulario
    $nuevoNombre = $this->request->getPost('usuario');
    $nuevoEmail = strtolower(trim($this->request->getPost('email')));

    // Comparar con los datos actuales
    $cambios = [];
    if ($nuevoNombre !== $usuarioActual['usuario']) {
        $cambios['usuario'] = ['antes' => $usuarioActual['usuario'], 'despues' => $nuevoNombre];
    }
    if ($nuevoEmail !== $usuarioActual['email']) {
        $cambios['email'] = ['antes' => $usuarioActual['email'], 'despues' => $nuevoEmail];
    }

    // Si hay cambios, actualizar y enviar correo
    if (!empty($cambios)) {
        $usuarioModel->update($idusuario, [
            'usuario' => $nuevoNombre,
            'email' => $nuevoEmail
        ]);

        // Enviar correo informando cambios
        $this->_enviarCorreoActualizacion($nuevoEmail, $nuevoNombre, $cambios);

        session()->setFlashdata('success', 'Usuario actualizado correctamente.');
    } else {
        session()->setFlashdata('info', 'No se realizaron cambios.');
    }

    return redirect()->to('/vista_admin');
}

// Función privada para enviar correo de actualización
private function _enviarCorreoActualizacion($email, $usuario, $cambios)
{
    $emailService = \Config\Services::email();

    $emailService->setFrom('timbreautomatico2025@gmail.com', 'Sistema de Gestión de Timbres');
    $emailService->setTo($email);
    $emailService->setSubject('Actualización de tus datos');

    $mensaje = "<h2>Hola {$usuario},</h2>";
    $mensaje .= "<p>Se han realizado los siguientes cambios en tu cuenta:</p><ul>";
    foreach ($cambios as $campo => $valores) {
        $mensaje .= "<li><strong>" . ucfirst($campo) . ":</strong> {$valores['antes']} → {$valores['despues']}</li>";
    }
    $mensaje .= "</ul><p>Si no realizaste estos cambios, contacta con tu administrador.</p>";
    $mensaje .= "<br><p>Saludos,<br>Equipo del Sistema de Gestión de Timbres</p>";

    $emailService->setMessage($mensaje);
    $emailService->setMailType('html');

    if (!$emailService->send()) {
        log_message('error', 'Error al enviar el correo de actualización a ' . $email);
    }
}
public function calendario()
{
    return view('calendario_admin');
}

public function solicitudesPendientes()
{
    $session = \Config\Services::session();
    $usuarioColegioModel = new \App\Models\UsuarioColegioModel();
    $solicitudModel = new \App\Models\SolicitudAdminModel();
    $usuarioModel = new \App\Models\Usuario();
    $adminAceptadosModel = new \App\Models\AdminAceptadosModel(); // 👈 nuevo

    $idusuario = session()->get('idusuario');

    // Obtener colegio donde el usuario es admin
    $adminColegio = $usuarioColegioModel
        ->where('idusuario', $idusuario)
        ->where('idrol', 1)
        ->first();

    if (!$adminColegio) {
        return redirect()->to('/admin')->with('error', 'No eres admin de ninguna institución.');
    }

    $idcolegio = $adminColegio['idcolegio'];

    // Obtener solicitudes pendientes
    $solicitudes = $solicitudModel->obtenerPendientesPorColegio($idcolegio);

    foreach ($solicitudes as &$sol) {
        $usr = $usuarioModel->find($sol['idusuario']);
        $sol['usuario'] = $usr['usuario'];
        $sol['email'] = $usr['email'];
    }

    // 👇 Obtener los admins ya aceptados (historial)
    $admins = $adminAceptadosModel
        ->where('idcolegio', $idcolegio)
        ->orderBy('fecha_aceptacion', 'DESC')
        ->findAll();

foreach ($admins as &$a) {
    $usr = $usuarioModel->find($a['idusuario']);
    $a['usuario'] = $usr['usuario'] ?? 'Sin nombre';
    $a['email'] = $usr['email'] ?? 'Sin email';

    // Renombrar fecha para la vista
    $a['fecha_registro'] = $a['fecha_aceptacion'] ?? '';
}

  return view('solicitudes_admin', [
        'solicitudes' => $solicitudes,
        'admins' => $admins 
    ]);
}


public function procesarSolicitud()
{
    $solicitudModel = new \App\Models\SolicitudAdminModel();
    $usuarioColegioModel = new \App\Models\UsuarioColegioModel();
    $usuarioModel = new \App\Models\Usuario(); 
    $adminAceptadosModel = new \App\Models\AdminAceptadosModel(); // ✅ Nuevo modelo

    $data = $this->request->getJSON();

    if (!$data || !isset($data->id) || !isset($data->estado)) {
        return $this->response->setJSON(['status' => 'error', 'msg' => 'Datos inválidos']);
    }

    $solicitud = $solicitudModel->find($data->id);
    if (!$solicitud) {
        return $this->response->setJSON(['status' => 'error', 'msg' => 'Solicitud no encontrada']);
    }

    $usuario = $usuarioModel->find($solicitud['idusuario']);
    if (!$usuario) {
        return $this->response->setJSON(['status' => 'error', 'msg' => 'Usuario no encontrado']);
    }

    $nombreUsuario = $usuario['usuario'];
    $emailUsuario = $usuario['email'];
    $email = \Config\Services::email();

    if ($data->estado === 'aceptada') {
        // Verificar si ya existe asociación
        $yaAsociado = $usuarioColegioModel
            ->where('idusuario', $solicitud['idusuario'])
            ->where('idcolegio', $solicitud['idcolegio'])
            ->first();

        if ($yaAsociado) {
            $nuevoTotal = $yaAsociado['total_comprados'] + ($solicitud['cantidad'] ?? 1);
            $usuarioColegioModel->update($yaAsociado['id'], ['total_comprados' => $nuevoTotal]);
        } else {
            $usuarioColegioModel->insert([
                'idusuario' => $solicitud['idusuario'],
                'idcolegio' => $solicitud['idcolegio'],
                'idrol' => 1,
                'total_comprados' => $solicitud['cantidad'] ?? 1
            ]);
        }

        // ✅ Registrar aceptación en historial
        $adminAceptadosModel->insert([
            'idusuario' => $solicitud['idusuario'],
            'idcolegio' => $solicitud['idcolegio']
        ]);

        // ✅ Enviar email de aceptación
        $email->setTo($emailUsuario);
        $email->setSubject('Solicitud de Admin Aceptada');
        $email->setMessage("
            Hola {$nombreUsuario},<br><br>
            Tu solicitud para ser administrador del colegio con ID {$solicitud['idcolegio']} ha sido <strong>ACEPTADA</strong>.<br>
            Ya puedes acceder con tus credenciales.<br><br>
            Saludos,<br>RingMind
        ");
        $email->send();

        $msg = "Solicitud aceptada correctamente y registrada en historial.";

    } else {
        // ✅ Enviar email de rechazo
        $email->setTo($emailUsuario);
        $email->setSubject('Solicitud de Admin Rechazada');
        $email->setMessage("
            Hola {$nombreUsuario},<br><br>
            Lamentamos informarte que tu solicitud para ser administrador del colegio con ID {$solicitud['idcolegio']} ha sido <strong>RECHAZADA</strong>.<br><br>
            Saludos,<br>RingMind
        ");
        $email->send();

        $msg = "Solicitud rechazada correctamente.";
    }

    // Actualizar estado
    $solicitudModel->actualizarEstado($data->id, $data->estado);

    return $this->response->setJSON(['status' => 'ok', 'msg' => $msg]);
}

}