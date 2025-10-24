<?php

namespace App\Controllers;

use App\Models\DispositivoModel;

class TimbreController extends BaseController
{
    protected $dispositivoModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
    }

public function activarTimbreManual()
{
    $session = session();

    // Verificar que haya sesión y que el usuario sea directivo
    $idColegio = $session->get('idcolegio');
    $idRol = $session->get('idrol');

    if (!$idColegio || !$idRol || $idRol != 2) {
        // Redirige al login con mensaje de error
        return redirect()->to('/login')->with('error', 'Sesión inválida o no autorizada. Por favor, inicia sesión nuevamente.');
    }

    // Obtener dispositivos asociados al colegio con IP válida
    $dispositivos = $this->dispositivoModel
        ->where('idcolegio', $idColegio)
        ->where('ip IS NOT NULL')    // IP no nula
        ->where('ip !=', '')         // IP no vacía
        ->findAll();

    if (empty($dispositivos)) {
        return redirect()->back()->with('error', 'No hay dispositivos con IP registrada para este colegio.');
    }

    // Crear cliente cURL (Config Services)
    $client = \Config\Services::curlrequest();

    foreach ($dispositivos as $disp) {
     $url = 'http://' . $disp['ip'] . '/tocar?key=R1ngM1nd2025';

        try {
            $client->get($url, ['timeout' => 2]); // timeout opcional
        } catch (\Exception $e) {
            log_message('error', 'Error al tocar timbre en IP ' . $disp['ip'] . ': ' . $e->getMessage());
        }
    }

    return redirect()->back();
}

}

?>