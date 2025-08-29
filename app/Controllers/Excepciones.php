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
    public function eliminar($id)
{
    $session = session();
    $model = new ExcepcionesModel();

    $excepcion = $model->find($id);
    if(!$excepcion){
        $session->setFlashdata('error', 'Excepción no encontrada.');
        return redirect()->back();
    }

    $model->delete($id);
    $session->setFlashdata('success', 'Excepción eliminada correctamente.');
    return redirect()->back();
}

public function modificar($id)
{
    $session = session();
    $model = new ExcepcionesModel();
    $request = $this->request;

    $excepcion = $model->find($id);
    if(!$excepcion){
        $session->setFlashdata('error', 'Excepción no encontrada.');
        return redirect()->back();
    }

    if($request->getMethod() === 'post'){
        $fecha = $request->getPost('fecha');
        $motivo = $request->getPost('motivo');

        if(!$fecha){
            $session->setFlashdata('error', 'Debe seleccionar una fecha.');
            return redirect()->back();
        }

        $model->update($id, [
            'fecha' => $fecha,
            'motivo' => $motivo
        ]);

        $session->setFlashdata('success', 'Excepción modificada correctamente.');
        return redirect()->to(base_url('feriados')); // o donde quieras redirigir
    }

    // Vista para modificar la excepción
    return view('excepciones_modificar', ['excepcion' => $excepcion]);
}

}
