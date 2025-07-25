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
        $iddia = $this->request->getPost('iddia'); // Nuevo campo
    
        // Validar hora
        $horaParsed = date_create($nuevaHora);
        if (!$horaParsed || date_format($horaParsed, 's') !== '00') {
            session()->setFlashdata('error', 'La hora debe ser precisa.');
            return redirect()->to('/horarios/editar/' . $idhorario);
        }
    
        // Validar día
        if (!in_array($iddia, ['1', '2', '3', '4', '5', '6', '7'])) {
            session()->setFlashdata('error', 'Seleccioná un día válido.');
            return redirect()->to('/horarios/editar/' . $idhorario);
        }
    
        // Verificar si ya existe esa hora para ese día en otro horario
        $existe = $model
            ->where('hora', $nuevaHora)
            ->where('idcolegio', $idcolegio)
            ->where('iddia', $iddia)
            ->where('idhorario !=', $idhorario)
            ->first();
    
        if ($existe) {
            session()->setFlashdata('error', 'Esa hora ya está registrada para ese día en este colegio.');
            return redirect()->to('/horarios/editar/' . $idhorario);
        }
    
        // Actualizar horario
        $data = [
            'evento' => $evento,
            'hora'   => $nuevaHora,
            'iddia'  => $iddia
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
        $idcolegio = $session->get('idcolegio'); // Obtenemos el colegio desde la sesión
    
        $horariosModel = new HorariosModel();
        $evento = $this->request->getVar('evento');
        $hora = $this->request->getVar('hora');
        $iddia = $this->request->getVar('iddia');
    
        // Validar formato de hora (segundos en 00)
        $horaParsed = date_create($hora);
        if (!$horaParsed || date_format($horaParsed, 's') !== '00') {
            session()->setFlashdata('error', 'La hora debe ser precisa.');
            return redirect()->to(base_url('horarios/agregar'));
        }
    
        // Validar selección del día
        if (!in_array($iddia, ['1', '2', '3', '4', '5', '6', '7'])) {
            session()->setFlashdata('error', 'Seleccioná un día válido.');
            return redirect()->to(base_url('horarios/agregar'));
        }
    
        // Verificar que no exista la misma hora en ese colegio y ese día
        $existingHorario = $horariosModel
            ->where('hora', $hora)
            ->where('idcolegio', $idcolegio)
            ->where('iddia', $iddia)
            ->first();
    
        if ($existingHorario) {
            session()->setFlashdata('error', 'La hora ya está registrada para ese día en este colegio.');
            return redirect()->to(base_url('horarios/agregar'));
        }
    
        // Guardar el nuevo horario
        $data = [
            'evento'    => $evento,
            'hora'      => $hora,
            'idcolegio' => $idcolegio,
            'idturno'   => $idturno,
            'iddia'     => $iddia
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

    public function checkTime()
    {
        $mac = $this->request->getVar('mac');
        $response = ['tocar' => false]; // Valor por defecto
    
        if (!$mac) {
            return $this->response->setJSON($response);
        }
    
        $db = \Config\Database::connect();
    
        // Buscar dispositivo por MAC
        $dispositivo = $db->table('dispositivo')
                          ->where('mac', $mac)
                          //->where('estado', 1) // ❗Descomentar si querés usar el estado
                          ->get()
                          ->getRow();
    
        if (!$dispositivo) {
            return $this->response->setJSON($response);
        }
    
        $idcolegio = $dispositivo->idcolegio;
    
        // Obtener hora y día actual del servidor
        date_default_timezone_set('America/Argentina/Buenos_Aires'); // Asegurate de ajustar según tu zona
        $horaActual = date('H:i:00'); // formato HH:MM:00 para coincidir con campo TIME
        $diaSemana = date('N'); // 1 (Lunes) a 7 (Domingo)
    
        // Buscar coincidencia en horarios
        $horario = $db->table('horarios')
                      ->where('idcolegio', $idcolegio)
                      ->where('hora', $horaActual)
                      ->where('iddia', $diaSemana)
                      ->get()
                      ->getRow();
    
        if ($horario) {
            $response['tocar'] = true;
        }
    
        return $this->response->setJSON($response);
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