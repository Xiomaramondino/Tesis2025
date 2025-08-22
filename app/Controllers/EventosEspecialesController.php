<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EventosEspecialesModel;

class EventosEspecialesController extends Controller
{
    protected $eventosModel;

    public function __construct()
    {
        $this->eventosModel = new EventosEspecialesModel();
    }
    public function delete($id = null)
    {
        if ($id) {
            $db = \Config\Database::connect();
            $db->table('eventos_especiales')->delete(['id' => $id]);
            session()->setFlashdata('success', 'Evento especial eliminado correctamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo eliminar el evento especial.');
        }
    
        return redirect()->back();
    }
    
    public function agregar()
    {
        $session = session();
        $idcolegio = $session->get('idcolegio');
    
        $db = \Config\Database::connect();
        $tieneDispositivos = $db->table('dispositivo')
                                ->where('idcolegio', $idcolegio)
                                ->countAllResults() > 0;
    
        if (!$tieneDispositivos) {
            session()->setFlashdata('error_evento', 'No se puede agregar eventos especiales porque no hay dispositivos registrados para este colegio.');
            return redirect()->back();
        }
    
        // Obtenemos los datos del formulario
        $fecha = $this->request->getPost('fecha');
        $hora = $this->request->getPost('hora');
        $descripcion = $this->request->getPost('descripcion');
    
        // Validación: no permitir fecha y hora pasadas
        $eventoDateTime = strtotime($fecha . ' ' . $hora);
        $ahora = time();
    
        if ($eventoDateTime < $ahora) {
            session()->setFlashdata('error_evento', 'No se puede agregar un evento en una fecha y hora ya pasada.');
            return redirect()->back();
        }
    
        // Si pasa la validación, insertamos
        $db->table('eventos_especiales')->insert([
            'idcolegio'   => $idcolegio,
            'fecha'       => $fecha,
            'hora'        => $hora,
            'descripcion' => $descripcion,
            'activo'      => 1
        ]);
    
        session()->setFlashdata('success_evento', 'Evento especial agregado correctamente.');
        return redirect()->back();
    }
       
}
