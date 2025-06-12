<?php
// app/Controllers/Horarios.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\HorariosModel;

class Horarios extends Controller
{

    public function index()
    {
        $session = session();
        $idcolegio = $session->get('idcolegio'); // Obtenemos solo el colegio
    
        $model = new \App\Models\HorariosModel();
    
        // Filtramos directamente usando el modelo
        $data = $model->where('idcolegio', $idcolegio)->findAll();
    
        return view('horarios', ['data' => $data]);
    }
    
    

    public function editar($idhorario = null)
    {
        $model = new HorariosModel();

        if ($idhorario === null) {
            return redirect()->to('/horarios');
        }

        $data['horario'] = $model->getHorario($idhorario);


        return view('editar_horario', $data);
    }

    public function actualizar()
{
    $session = session();
    $idturno = $session->get('idturno');
    $idcolegio = $session->get('idcolegio'); // Obtenemos el colegio desde la sesión

    $model = new HorariosModel();
    $idhorario = $this->request->getPost('idhorario');
    $nuevaHora = $this->request->getPost('hora');
    $evento = $this->request->getPost('evento');

    $horaParsed = date_create($nuevaHora);
    if (!$horaParsed || date_format($horaParsed, 's') !== '00') {
        session()->setFlashdata('error', 'La hora debe ser precisa.');
        return redirect()->to('/horarios/editar/' . $idhorario);
    }


    // Verificar si existe la misma hora en el mismo colegio pero en un horario diferente
    $existe = $model
        ->where('hora', $nuevaHora)
        ->where('idcolegio', $idcolegio)
        ->where('idhorario !=', $idhorario)
        ->first();

    if ($existe) {
        session()->setFlashdata('error', 'Esa hora ya está registrada para otro evento en este colegio.');
        return redirect()->to('/horarios/editar/' . $idhorario);
    }

    $data = [
        'evento' => $evento,
        'hora' => $nuevaHora,
    ];

    $model->update($idhorario, $data);

    session()->setFlashdata('success', 'Horario actualizado correctamente.');
    return redirect()->to('/horarios');
}


    public function agregar()
    {
        return view('horarios_add');
    }

    public function add()
    {
        $session = session();
        $idturno = $session->get('idturno');
        $idcolegio = $session->get('idcolegio'); // Obtenemos el colegio
    
        $horariosModel = new HorariosModel();
        $evento = $this->request->getVar('evento');
        $hora = $this->request->getVar('hora');
    
        $horaParsed = date_create($hora);
        if (!$horaParsed || date_format($horaParsed, 's') !== '00') {
            session()->setFlashdata('error', 'La hora debe ser precisa.');
            return redirect()->to(base_url('horarios/agregar'));
        }
    
    
        $existingHorario = $horariosModel
        ->where('hora', $hora)
        ->where('idcolegio', $idcolegio)
        ->first();
    
    if ($existingHorario) {
        session()->setFlashdata('error', 'La hora ya está registrada en este colegio.');
        return redirect()->to(base_url('horarios/agregar'));
    }
    
        $data = [
            'evento' => $evento,
            'hora' => $hora,
            'idcolegio' => $idcolegio, 
            'idturno' => $idturno,    
        ];
    
        $horariosModel->insert($data);
    
        session()->setFlashdata('success', 'Horario agregado correctamente.');
        return redirect()->to(base_url('horarios'));
    }
    
    public function delete($idhorario)
    {
 
        $horariosModel = new HorariosModel();

       
        $horariosModel->delete($idhorario);

      
        return redirect()->to(base_url('horarios'));
    }

    public function checkTime() {
        $horaActual = $this->request->getVar('hora');
        $mac = $this->request->getVar('mac');
    
        error_log("Hora recibida: " . $horaActual); 
        error_log("MAC recibida: " . $mac);
    
        $db = \Config\Database::connect();
    
        // Buscar el dispositivo por MAC
        $builderDispositivo = $db->table('dispositivo');
        $builderDispositivo->where('mac', $mac);
        $dispositivo = $builderDispositivo->get()->getRow();
    
        if (!$dispositivo) {
            error_log("Dispositivo con MAC no encontrado");
            return $this->response->setBody("no");
        }
    
        $idcolegio = $dispositivo->idcolegio;
    
        // Buscar horarios coincidentes para ese colegio
        $builderHorarios = $db->table('horarios');
        $builderHorarios->where('hora', $horaActual);
        $builderHorarios->where('idcolegio', $idcolegio);
        $horarios = $builderHorarios->get()->getResult();
    
        if (count($horarios) > 0) {
            error_log("Coincidencia encontrada para: " . $horaActual . " en colegio ID: " . $idcolegio); 
            return $this->response->setBody("si");
        } else {
            error_log("No hay coincidencias para: " . $horaActual . " en colegio ID: " . $idcolegio); 
            return $this->response->setBody("no");
        }
    }
    

    public function horariosLector() 
    {
        $session = session();
        $idcolegio = $session->get('idcolegio'); 
    
        if (!$idcolegio) {
            session()->setFlashdata('error', 'No se pudo determinar el colegio del alumno.');
            return redirect()->to('/login');
        }
    
        $model = new \App\Models\HorariosModel();
        $builder = $model->builder();
    
        $builder->where('idcolegio', $idcolegio); 
        $builder->orderBy('hora', 'ASC'); 
    
        $query = $builder->get();
        $data = $query->getResult();
    
        return view('horarios_lector', ['data' => $data]);
    }
    public function horariosAdmin() 
{
    $session = session();
    $idcolegio = $session->get('idcolegio'); 

    if (!$idcolegio) {
        session()->setFlashdata('error', 'No se pudo determinar el colegio del administrador.');
        return redirect()->to('/login');
    }

    $model = new \App\Models\HorariosModel();
    $builder = $model->builder();

    $builder->where('idcolegio', $idcolegio); 
    $builder->orderBy('hora', 'ASC'); 

    $query = $builder->get();
    $data = $query->getResult();

    return view('horarios_admin', ['data' => $data]);
}

    }

?>