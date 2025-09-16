<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ProfesorController extends Controller
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
        helper(['form', 'url', 'session']);
    }

    /**
     * Vista principal de avisos/calendario del profesor
     */
    public function avisos()
    {
        $idusuario = $this->session->get('idusuario');
        $idcolegio = $this->session->get('idcolegio');
    
        // Traer cursos del profesor si existe la tabla profesor_curso
        $cursosProfesor = $this->db->table('profesor_curso')
            ->select('idcurso')
            ->where('idusuario', $idusuario)
            ->get()
            ->getResultArray();
    
        $cursosIds = array_column($cursosProfesor, 'idcurso');
    
        $builder = $this->db->table('avisos');
    
        // Si hay cursos asignados, usamos whereIn, si no, solo avisos generales
        if (!empty($cursosIds)) {
            $builder->groupStart()
                ->where('idusuario', $idusuario) // sus propios avisos
                ->orGroupStart()
                    ->whereIn('idcurso', $cursosIds)
                    ->orWhere('idcurso', null)      // avisos generales
                ->groupEnd()
            ->groupEnd();
        } else {
            $builder->groupStart()
                ->where('idusuario', $idusuario)
                ->orWhere('idcurso', null) // solo generales
            ->groupEnd();
        }
    
        $builder->where('idcolegio', $idcolegio)
                ->orderBy('fecha', 'DESC');
    
        $avisos = $builder->get()->getResult();
    
        return view('profesor/avisos', ['avisos' => $avisos]);
    }
    public function horariosProfesor() 
{
    $session = session();
    $idcolegio = $session->get('idcolegio'); 

    if (!$idcolegio) {
        session()->setFlashdata('error', 'No se pudo determinar el colegio del profesor.');
        return redirect()->to('/login');
    }

    // Traer horarios del colegio
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

    return view('horarios_profesor', [
        'data' => $data,
        'eventosEspeciales' => $eventosEspeciales
    ]);
}

}    
