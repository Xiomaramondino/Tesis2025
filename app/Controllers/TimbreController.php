<?php

namespace App\Controllers;

use App\Models\DispositivoModel;
use App\Models\TimbreManualModel;

class TimbreController extends BaseController
{
    protected $dispositivoModel;
    protected $timbreManualModel;

    public function __construct()
    {
        $this->dispositivoModel = new DispositivoModel();
        $this->timbreManualModel = new TimbreManualModel();
    }

    /**
     * Maneja el POST del botón "Sonar timbre"
     * Solo activa el timbre de dispositivos asociados al colegio actual.
     */
    public function sonarTimbre()
    {
        $idColegio = session()->get('idcolegio');

        if (!$idColegio) {
            return redirect()->back()->with('error', 'Sesión inválida. Iniciá sesión nuevamente.');
        }

        // Obtener dispositivos vinculados a este colegio
        $dispositivos = $this->dispositivoModel
            ->where('idcolegio', $idColegio)
            ->findAll();

        if (empty($dispositivos)) {
            return redirect()->back()->with('error', 'No hay dispositivos asociados a este colegio.');
        }

        // Registrar una orden de timbre manual para cada dispositivo del colegio
        foreach ($dispositivos as $disp) {
            $this->timbreManualModel->insert([
                'mac' => $disp['mac'],
                'pendiente' => 1
            ]);
        }

        return redirect()->back();

    }
}

?>