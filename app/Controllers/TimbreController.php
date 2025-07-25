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
        $idColegio = session()->get('idcolegio');
        if (!$idColegio) {
            return redirect()->back()->with('error', 'Sesión inválida. Por favor, inicia sesión nuevamente.');
        }

        // Obtener dispositivos asociados al colegio con IP válida
        $dispositivos = $this->dispositivoModel
            ->where('idcolegio', $idColegio)
            ->where('ip IS NOT NULL')    // si quieres asegurarte que la IP no sea nula
            ->where('ip !=', '')         // y que no sea cadena vacía
            ->findAll();

        if (empty($dispositivos)) {
            return redirect()->back()->with('error', 'No hay dispositivos con IP registrada para este colegio.');
        }

        // Crear cliente cURL (Config Services)
        $client = \Config\Services::curlrequest();

        foreach ($dispositivos as $disp) {
            $url = 'http://' . $disp['ip'] . '/tocar';

            try {
                $client->get($url, ['timeout' => 2]); // timeout opcional para no esperar mucho
            } catch (\Exception $e) {
                log_message('error', 'Error al tocar timbre en IP ' . $disp['ip'] . ': ' . $e->getMessage());
            }
        }

        return redirect()->back();
    }
}

?>