<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\DispositivoModel;
use App\Models\ExcepcionesModel;

class Feriados extends Controller
{
    public function ver()
    {
        $anio = date('Y');
        $session = session();
        $idcolegio = $session->get('idcolegio');

        // 1️⃣ Consultar API de feriados argentinos
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

        // 2️⃣ Consultar excepciones propias del colegio
        $excepcionesModel = new ExcepcionesModel();
        $excepcionesDB = $excepcionesModel
            ->where('idcolegio', $idcolegio)
            ->findAll();

            foreach ($excepcionesDB as $ex) {
                array_unshift($feriados, [  // ← se usa array_unshift para ponerlo al principio
                    'date' => $ex->fecha,
                    'localName' => $ex->motivo ? "Excepción: {$ex->motivo}" : "Excepción",
                ]);
            }

        // 3️⃣ Obtener dispositivos asociados al idcolegio
        $dispositivoModel = new DispositivoModel();
        $dispositivos = $dispositivoModel->where('idcolegio', $idcolegio)->findAll();

        // 4️⃣ Cargar vista
        return view('feriados_view', [
            'feriados' => $feriados,
            'dispositivos' => $dispositivos
        ]);
    }
}
