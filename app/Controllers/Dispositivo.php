<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Usuario;
use App\Models\DispositivoModel;


class Dispositivo extends ResourceController
{
    
    protected $format    = 'json';

    public function __construct()
    {
        $this->model = new DispositivoModel();
    }
    
  public function registerMac()
    {
        $mac = $this->request->getGet('mac');
        if (!$mac) {
            return $this->respond(['status' => 'error', 'message' => 'MAC no recibida'], 400);
        }

        // Validar MAC (opcional)
        if (!preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $mac)) {
            return $this->respond(['status' => 'error', 'message' => 'MAC inválida'], 400);
        }

        // Verificar si ya existe la MAC
        $existing = $this->model->where('mac', $mac)->first();
        if ($existing) {
            return $this->respond(['status' => 'ok', 'message' => 'MAC ya registrada']);
        }

        // Insertar nueva MAC
        $this->model->insert(['mac' => $mac, 'estado' => 'no asociado']);

        return $this->respond(['status' => 'ok', 'message' => 'MAC registrada correctamente']);
    }  
    public function vistaDispositivos()
{
    $session = session();
    $idusuario = $session->get('idusuario');

    // Obtener el nombre del usuario actual
    $usuarioModel = new UsuarioModel();
    $usuario = $usuarioModel->find($idusuario);

    if (!$usuario) {
        return redirect()->back()->with('error', 'Usuario no encontrado');
    }

    // Obtener dispositivos asociados a ese nombre de usuario
    $dispositivoModel = new DispositivoModel();
    $mis_dispositivos = $dispositivoModel->getDispositivosUsuario($usuario['nombre']);

    return view('registrar_dispositivo', ['mis_dispositivos' => $mis_dispositivos]);
}

}
