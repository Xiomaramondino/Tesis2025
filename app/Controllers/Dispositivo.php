<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Usuario;
use App\Models\DispositivoModel;
use App\Models\TimbreManualModel;



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
    
        if (!$idusuario) {
            return redirect()->to('/login')->with('error', 'Sesión no iniciada.');
        }
    
        // Obtener dispositivos por idusuario
        $mis_dispositivos = $this->where('idusuario', $idusuario)->findAll();
    
        return view('registrar_dispositivo', [
            'mis_dispositivos' => $mis_dispositivos
        ]);
    }

    public function checkManualRing()
    {
        $mac = $this->request->getGet('mac');
    
        if (!$mac) {
            return $this->response->setBody("no");
        }
    
        $timbreManualModel = new TimbreManualModel();
    
        $timbre = $timbreManualModel
            ->where('mac', $mac)
            ->where('pendiente', 1)
            ->orderBy('timestamp', 'DESC')
            ->first();
    
        if ($timbre) {
            $timbreManualModel
                ->where('id', $timbre['id'])
                ->set(['pendiente' => 0])
                ->update();
    
            return $this->response->setBody("si");
        }
    
        return $this->response->setBody("no");
    }
         

}
