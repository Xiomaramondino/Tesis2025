<?php
namespace App\Controllers;

use App\Models\Usuario;
use App\Models\CursoModel;

class DirectivoController extends BaseController
{
    protected $Usuario;
    protected $db;
    
    public function __construct()
    {
        // Inicializar modelo
        $this->Usuario = new Usuario();
    
        // Inicializar conexión a la base de datos
        $this->db = \Config\Database::connect();
    
        // Cargar helpers si los vas a usar
        helper(['form', 'url', 'session']);
    }
    

    public function gestionarUsuarios()
    {
        $idcolegio = session()->get('idcolegio');
    
        $db = \Config\Database::connect();
    
        // Obtener alumnos asociados al colegio
        $lectores = $db->table('usuario_colegio uc')
            ->select('u.idusuario, u.usuario, u.email')
            ->join('usuarios u', 'u.idusuario = uc.idusuario')
            ->where('uc.idcolegio', $idcolegio)
            ->where('uc.idrol', 3)
            ->orderBy('u.usuario', 'ASC')
            ->get()
            ->getResultArray();
    
        // Obtener cursos cargados por el colegio
        $cursos = $db->table('cursos')
            ->where('idcolegio', $idcolegio)
            ->orderBy('nombre', 'ASC')
            ->get()
            ->getResultArray();
    
        return view('gestionar_usuarios', [
            'lectores' => $lectores,
            'cursos' => $cursos
        ]);
    }
    
    // Agregar nuevo lector con contraseña aleatoria y token de recuperación
    public function agregarUsuario()
{
    $data = $this->request->getPost();
    $email = strtolower(trim($data['email']));
    $usuario = $data['usuario'];
    $idcurso = $data['idcurso'] ?? null; // Curso seleccionado en el formulario

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

    $db = \Config\Database::connect();
    $tieneMac = $db->table('dispositivo')
        ->where('idcolegio', $idcolegio)
        ->countAllResults();

    if ($tieneMac == 0) {
        session()->setFlashdata('error', 'No se puede agregar alumnos porque este colegio no tiene un dispositivo registrado.');
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

        // Asociar al curso seleccionado si existe
        if ($idcurso) {
            $db->table('alumno_curso')->insert([
                'idusuario' => $idusuario,
                'idcurso' => $idcurso
            ]);
        }

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

        // Asociar al curso seleccionado si existe
        if ($idcurso) {
            $db->table('alumno_curso')->insert([
                'idusuario' => $idusuario,
                'idcurso' => $idcurso
            ]);
        }

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
        $usuarioModel = new Usuario();
        $cursoModel   = new CursoModel();
    
        // Traigo los datos del usuario
        $usuario = $usuarioModel->find($idusuario);
    
        // Traigo el curso real desde alumno_curso
        $alumnoCursoTable = $this->db->table('alumno_curso');
        $registroCurso = $alumnoCursoTable->where('idusuario', $idusuario)->get()->getRowArray();
    
        // Agrego idcurso al array de usuario para usarlo en el select
        $usuario['idcurso'] = $registroCurso['idcurso'] ?? '';
    
        // Traigo todos los cursos del colegio
        $cursos = $cursoModel->where('idcolegio', session()->get('idcolegio'))->findAll();
    
        $data = [
            'usuario' => $usuario,
            'cursos'  => $cursos
        ];
    
        return view('editar_usuario', $data);
    }
    

    public function actualizarUsuario()
    {
        $data = $this->request->getPost();
        $id = $data['idusuario'];
    
        // Verificar si el usuario existe
        $usuarioExistente = $this->Usuario->find($id);
    
        if (!$usuarioExistente) {
            session()->setFlashdata('error', 'El usuario no existe.');
            return redirect()->to('/gestionar_usuarios');
        }
    
        // Datos nuevos
        $nuevoEmail   = strtolower(trim($data['email']));
        $nuevoUsuario = trim($data['usuario']);
        $nuevoCurso   = $data['idcurso'] ?? null; // Capturamos el curso seleccionado
    
        $cambios = [];
        $mensajeCambios = [];
    
        // Comparación de usuario
        if ($usuarioExistente['usuario'] !== $nuevoUsuario) {
            $cambios['usuario'] = $nuevoUsuario;
            $mensajeCambios[] = "Nombre de usuario actualizado.";
        }
    
        // Comparación de email
        if (strtolower($usuarioExistente['email']) !== $nuevoEmail) {
            $cambios['email'] = $nuevoEmail;
            $mensajeCambios[] = "Correo electrónico actualizado.";
        }
    
        // === Comparación de curso en tabla alumno_curso ===
        $alumnoCursoTable = $this->db->table('alumno_curso');
        $registroCurso = $alumnoCursoTable->where('idusuario', $id)->get()->getRowArray();
        $cursoActual = $registroCurso['idcurso'] ?? null;
    
        $cambioCurso = false;
        if ($cursoActual != $nuevoCurso) {
            $cambioCurso = true;
            $mensajeCambios[] = "Curso actualizado.";
        }
    
        // === Actualización de usuario ===
        if (!empty($cambios)) {
            $this->Usuario->update($id, $cambios);
        }
    
        // === Actualización de curso en tabla alumno_curso ===
        if ($cambioCurso) {
            if ($registroCurso) {
                // Actualizar curso existente
                $alumnoCursoTable->where('idusuario', $id)
                                 ->update(['idcurso' => $nuevoCurso]);
            } else {
                // Insertar nuevo registro
                $alumnoCursoTable->insert([
                    'idusuario' => $id,
                    'idcurso'   => $nuevoCurso
                ]);
            }
        }
    
        // Enviar correo al usuario con todos los datos actualizados
        $detalleCambios = implode(" ", $mensajeCambios);
        $this->_enviarCorreoEdicionUsuario(
            $cambios['email'] ?? $usuarioExistente['email'],
            $cambios['usuario'] ?? $usuarioExistente['usuario'],
            $detalleCambios
        );
    
        // Mensaje flash según cambios
        if (!empty($mensajeCambios)) {
            session()->setFlashdata('success', 'Datos actualizados correctamente. ' . $detalleCambios);
        } else {
            session()->setFlashdata('info', 'No se detectaron cambios en los datos.');
        }
    
        return redirect()->to('/gestionar_usuarios');
    }
    
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
public function calendario()
{
    // Obtener datos que quieras pasar a la vista, por ejemplo los avisos del directivo
    $data['titulo'] = 'Calendario - RingMind (Directivo)';

    return view('calendario_directivo', $data);
}

}
