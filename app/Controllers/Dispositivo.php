<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Dispositivo extends ResourceController
{
    protected $modelName = 'App\Models\DispositivoModel';
    protected $format    = 'json';
    
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
}
