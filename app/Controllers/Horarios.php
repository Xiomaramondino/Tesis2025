<?php
// app/Controllers/Horarios.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\HorariosModel;
use App\Models\EventosEspecialesModel;

class Horarios extends Controller
{

    public function index()
{
    $session = session();
    $idcolegio = $session->get('idcolegio'); // Obtenemos el colegio del usuario

    // 1️⃣ Verificar si hay dispositivos asociados al colegio
    $dispositivoModel = new \App\Models\DispositivoModel();
    $dispositivos = $dispositivoModel->where('idcolegio', $idcolegio)
                                     ->where('estado', 1) // opcional, solo activos
                                     ->findAll();

    $tieneDispositivos = !empty($dispositivos);

    // 2️⃣ Traer horarios regulares
    $modelHorarios = new \App\Models\HorariosModel();
    $data = $modelHorarios->where('idcolegio', $idcolegio)->findAll();

    // 3️⃣ Traer eventos especiales activos
    $modelEventos = new \App\Models\EventosEspecialesModel();
    $hoy = date('Y-m-d');
    $modelEventos->where('fecha <', $hoy)->set(['activo' => 0])->update();

    $eventosEspeciales = $modelEventos
                         ->where('idcolegio', $idcolegio)
                         ->where('activo', 1)
                         ->orderBy('fecha', 'ASC')
                         ->findAll();

    // 4️⃣ Pasar todo a la vista
    return view('horarios', [
        'data' => $data,
        'eventosEspeciales' => $eventosEspeciales,
        'tieneDispositivos' => $tieneDispositivos // <- clave para la vista
    ]);
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
            session()->setFlashdata('error_horario', 'La hora debe ser precisa.');
            return redirect()->to('/horarios/editar/' . $idhorario);
        }
    
        // Validar día
        if (!in_array($iddia, ['1', '2', '3', '4', '5', '6', '7'])) {
            session()->setFlashdata('error_horario', 'Seleccioná un día válido.');
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
            session()->setFlashdata('error_horario', 'Esa hora ya está registrada para ese día en este colegio.');
            return redirect()->to('/horarios/editar/' . $idhorario);
        }
    
        // Actualizar horario
        $data = [
            'evento' => $evento,
            'hora'   => $nuevaHora,
            'iddia'  => $iddia
        ];
    
        $model->update($idhorario, $data);
    
        session()->setFlashdata('success_horario', 'Horario actualizado correctamente');
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
    
        session()->setFlashdata('success_horario', 'Horario agregado correctamente.');
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
                      //->where('estado', 1) // opcional
                      ->get()
                      ->getRow();

    if (!$dispositivo) {
        return $this->response->setJSON($response);
    }

    $idcolegio = $dispositivo->idcolegio;

    // Obtener fecha, hora y día actual
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fechaHoy   = date('Y-m-d');
    $horaActual = date('H:i:00');
    $diaSemana  = date('N'); // 1=lunes, 7=domingo
    $anio       = date('Y');

    // 1️⃣ Verificar excepciones manuales
    $excepcion = $db->table('excepciones')
                    ->where('idcolegio', $idcolegio)
                    ->where('fecha', $fechaHoy)
                    ->get()
                    ->getRow();

    if ($excepcion) {
        return $this->response->setJSON($response); // No sonar
    }

    // 2️⃣ Verificar feriados nacionales (API externa)
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://date.nager.at/api/v3/PublicHolidays/$anio/AR");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {
            $feriados = json_decode($result, true);

            foreach ($feriados as $feriado) {
                if ($feriado['date'] === $fechaHoy) {
                    return $this->response->setJSON($response); // Es feriado → no sonar
                }
            }
        }
    } catch (\Exception $e) {
        // Si la API falla, seguimos normalmente (no bloquea el timbre)
    }

    // 3️⃣ Verificar eventos especiales
    $evento = $db->table('eventos_especiales')
                 ->where('idcolegio', $idcolegio)
                 ->where('fecha', $fechaHoy)
                 ->where('hora', $horaActual)
                 ->where('activo', 1)
                 ->get()
                 ->getRow();

    if ($evento) {
        // Marcar como usado para que no se repita
        $db->table('eventos_especiales')
           ->where('id', $evento->id)
           ->delete();

        $response['tocar'] = true;
        return $this->response->setJSON($response);
    }

    // 4️⃣ Verificar horarios normales
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

    // Traer horarios normales
    $horariosModel = new \App\Models\HorariosModel();
    $horarios = $horariosModel->where('idcolegio', $idcolegio)
                              ->orderBy('hora', 'ASC')
                              ->findAll();

    // Traer eventos especiales activos
    $eventosModel = new \App\Models\EventosEspecialesModel();
    $eventos = $eventosModel->where('idcolegio', $idcolegio)
                             ->where('activo', 1)
                             ->orderBy('fecha', 'ASC')
                             ->orderBy('hora', 'ASC')
                             ->findAll();

    return view('horarios_lector', [
        'data' => $horarios,
        'eventos' => $eventos
    ]);
}

    public function horariosAdmin() 
    {
        $session = session();
        $idcolegio = $session->get('idcolegio'); 
    
        if (!$idcolegio) {
            session()->setFlashdata('error', 'No se pudo determinar el colegio del administrador.');
            return redirect()->to('/login');
        }
    
        // Traer horarios
        $model = new \App\Models\HorariosModel();
        $builder = $model->builder();
        $builder->where('idcolegio', $idcolegio); 
        $builder->orderBy('hora', 'ASC'); 
        $query = $builder->get();
        $data = $query->getResult();
    
        // Traer eventos especiales activos
        $db = \Config\Database::connect();
        $eventosEspeciales = $db->table('eventos_especiales')
                                ->where('idcolegio', $idcolegio)
                                ->where('activo', 1)
                                ->orderBy('fecha', 'ASC')
                                ->get()
                                ->getResult();
    
        return view('horarios_admin', [
            'data' => $data,
            'eventosEspeciales' => $eventosEspeciales
        ]);
    }
    
    }

?>