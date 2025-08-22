<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Feriados extends Controller
{
    public function ver()
    {
        $anio = date('Y');

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

        // Cargar vista
        return view('feriados_view', ['feriados' => $feriados]);
    }
}
