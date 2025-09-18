<?php
namespace App\Controllers;

use App\Models\CursoModel;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    public function index()
    {
        $session = session();
        $cursoModel = new CursoModel();
        
        $idcolegio = $session->get('idcolegio');
        $cursos = $cursoModel->where('idcolegio', $idcolegio)->findAll();
    
        // Si hay cursos y viene del “primer setup”, mostrar botón para ir a vista_admin
        $primerSetup = $this->request->getGet('setup') ?? false;
    
        return view('admin/cursos', [
            'cursos' => $cursos,
            'primerSetup' => $primerSetup
        ]);
    }
    
    public function guardar()
    {
        $session = session();
        $cursoModel = new \App\Models\CursoModel();
    
        $nombre = $this->request->getPost('nombre');
        $division = $this->request->getPost('division');
        $idcolegio = $session->get('idcolegio');
    
        $cursoModel->insert([
            'nombre' => $nombre,
            'division' => $division,
            'idcolegio' => $idcolegio
        ]);
    
        // Si viene del primer setup, mantenemos el setup
        $primerSetup = $this->request->getGet('setup') ?? 0;
        if ($primerSetup) {
            return redirect()->to('/cursos?setup=1');
        }
    
        return redirect()->to('/cursos');
    }
    

    public function eliminar($idcurso)
    {
        $session = session();
        $cursoModel = new CursoModel();

        $cursoModel->where('idcolegio', $session->get('idcolegio'))
                   ->delete($idcurso);

        return redirect()->to('/cursos');
    }
}
