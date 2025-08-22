<?php

namespace App\Controllers;
use App\Models\ExcepcionesModel;
use CodeIgniter\Controller;

class Excepciones extends Controller
{
    public function registrar()
    {
        $session = session();
        $request = $this->request;

        $fecha = $request->getPost('fecha');
        $motivo = $request->getPost('motivo');

        if(!$fecha){
            $session->setFlashdata('error', 'Debe seleccionar una fecha.');
            return redirect()->back();
        }

        // Suponiendo que el ID del colegio está en la sesión del admin
        $idcolegio = $session->get('idcolegio');

        $model = new ExcepcionesModel();

        // Verificar si ya existe la excepción
        $existe = $model->where('fecha', $fecha)
                        ->where('idcolegio', $idcolegio)
                        ->first();

        if($existe){
            $session->setFlashdata('error', 'Ya existe una excepción para esta fecha.');
            return redirect()->back();
        }

        // Guardar la excepción
        $model->insert([
            'idcolegio' => $idcolegio,
            'fecha' => $fecha,
            'motivo' => $motivo
        ]);

        $session->setFlashdata('success', 'Excepción registrada correctamente.');
        return redirect()->back();
    }
}
