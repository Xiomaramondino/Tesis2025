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
        $idturno = $session->get('idturno');  // Obtenemos el turno desde la sesión
        $idcolegio = $session->get('idcolegio'); // Obtenemos el colegio del usuario

        $model = new \App\Models\HorariosModel();
        $builder = $model->builder(); // Usamos query builder para filtrar

        $builder->where('idcolegio', $idcolegio);
    
        // Aplicamos el filtro según el turno del usuario
        if ($idturno === '1') {
            $builder->where('hora >=', '07:00:00')->where('hora <', '13:00:00');
        } elseif ($idturno === '2') {
            $builder->where('hora >=', '13:00:00')->where('hora <=', '22:00:00');
        } elseif ($idturno === '3') {
            // No filtramos, mostramos todo
        } else {
            // Turno no definido o inválido, puedes redirigir o mostrar mensaje
            
        }
    
        $query = $builder->get();
        $data = $query->getResult(); // Resultado filtrado según el turno
    
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

    $horaSolo = date_format($horaParsed, 'H:i:s');
    if ($idturno === '1' && ($horaSolo < '07:00:00' || $horaSolo >= '13:00:00')) {
        session()->setFlashdata('error', 'Solo puedes modificar horarios matutinos (07:00 a 13:00).');
        return redirect()->to('/horarios/editar/' . $idhorario);
    }
    if ($idturno === '2' && ($horaSolo < '13:00:00' || $horaSolo > '22:00:00')) {
        session()->setFlashdata('error', 'No puedes modificar a un horario matutino. Solo entre 13:00 y 22:00.');
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
    
        $horaSolo = date_format($horaParsed, 'H:i:s');
        if ($idturno === '1' && ($horaSolo < '07:00:00' || $horaSolo >= '13:00:00')) {
            session()->setFlashdata('error', 'Solo puedes agregar horarios matutinos (07:00 a 13:00).');
            return redirect()->to(base_url('horarios/agregar'));
        }
        if ($idturno === '2' && ($horaSolo < '13:00:00' || $horaSolo > '22:00:00')) {
            session()->setFlashdata('error', 'No puedes agregar horarios matutinos. Solo entre 13:00 y 22:00.');
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
        error_log("Hora recibida: " . $horaActual); 
    
      
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM horarios WHERE hora = ?", [$horaActual]);
        $result = $query->getResult();
    
        if (count($result) > 0) {
            error_log("Coincidencia encontrada para: " . $horaActual); 
            return $this->response->setBody("si");
        } 
        else {
            error_log("No hay coincidencias para: " . $horaActual); 
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
    
        $builder->where('idcolegio', $idcolegio); /
        $builder->orderBy('hora', 'ASC'); 
    
        $query = $builder->get();
        $data = $query->getResult();
    
        return view('horarios_lector', ['data' => $data]);
    }
    }

?>