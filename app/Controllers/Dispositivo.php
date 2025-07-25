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
    $ip = $this->request->getGet('ip');

    if (!$mac) {
        return $this->respond(['status' => 'error', 'message' => 'MAC no recibida'], 400);
    }

    // Validar formato de MAC
    if (!preg_match('/^([0-9A-Fa-f]{2}:){5}[0-9A-Fa-f]{2}$/', $mac)) {
        return $this->respond(['status' => 'error', 'message' => 'MAC inválida'], 400);
    }

    // Validar IP (opcional, pero recomendable)
    if ($ip && !filter_var($ip, FILTER_VALIDATE_IP)) {
        return $this->respond(['status' => 'error', 'message' => 'IP inválida'], 400);
    }

    // Buscar si ya existe la MAC
    $existing = $this->model->where('mac', $mac)->first();

    if ($existing) {
        // Actualizar IP si cambia o si se pasa
        if ($existing['ip'] !== $ip) {
            $this->model->update($existing['iddispositivo'], ['ip' => $ip]);
        }
        return $this->respond(['status' => 'ok', 'message' => 'MAC ya registrada, IP actualizada']);
    }

    // Insertar nueva MAC e IP
    $this->model->insert([
        'mac' => $mac,
        'ip' => $ip,
        'estado' => 'no asociado'
    ]);

    return $this->respond(['status' => 'ok', 'message' => 'MAC registrada correctamente']);
}

    
}
