<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\DispositivoModel;

class Feriados extends Controller
{
    public function ver()
    {
        $anio = date('Y');
        $session = session();
        $idcolegio = $session->get('idcolegio');

        // Consultar API de feriados argentinos
        $feriados = [];
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://date.nager.at/api/v3/PublicHolidays/$anio/AR");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result) {
                $feriados = json_decode($result, true);
            }
        } catch (\Exception $e) {
            $feriados = [];
        }

        // Obtener dispositivos asociados al idcolegio
        $dispositivoModel = new DispositivoModel();
        $dispositivos = $dispositivoModel->where('idcolegio', $idcolegio)->findAll();

        // Cargar vista
        return view('feriados_view', [
            'feriados' => $feriados,
            'dispositivos' => $dispositivos
        ]);
    }
}
