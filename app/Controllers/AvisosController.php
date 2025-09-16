<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Models\AvisoModel;

class AvisosController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['form', 'url', 'session']);
    }

    /**
     * Mostrar formulario para crear aviso
     */
    public function crearAviso()
    {
        $session = session();
        $idcolegio = $session->get('idcolegio');

        // Traer cursos del colegio
        $cursos = $this->db->table('cursos')
            ->where('idcolegio', $idcolegio)
            ->get()
            ->getResult();

        return view('avisos/crear', [
            'cursos' => $cursos
        ]);
    }

    /**
     * Guardar aviso en la base de datos
     */
    public function guardarAviso()
    {
        $session = session();
        $idusuario = $session->get('idusuario');
        $idcolegio = $session->get('idcolegio');

        $titulo = $this->request->getPost('titulo');
        $descripcion = $this->request->getPost('descripcion');
        $fecha = $this->request->getPost('fecha'); // formato: YYYY-MM-DD HH:MM
        $idcurso = $this->request->getPost('idcurso') ?: null;
        $visibilidad = $this->request->getPost('visibilidad');

        $data = [
            'idcolegio' => $idcolegio,
            'idcurso' => $idcurso,
            'idusuario' => $idusuario,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha' => $fecha,
            'visibilidad' => $visibilidad
        ];

        $this->db->table('avisos')->insert($data);

        return redirect()->to(base_url('profesor/avisos'))->with('success', 'Aviso creado correctamente.');
    }

    public function listarJson()
    {
        $session = session();
        $idusuario = $session->get('idusuario');
        $idcolegio = $session->get('idcolegio');
        $idrol = $session->get('idrol');
    
        $start = $this->request->getGet('start');
        $end   = $this->request->getGet('end');
    
        $builder = $this->db->table('avisos');
        $builder->where('idcolegio', $idcolegio);
    
        // Filtro por rol y visibilidad
        if ($idrol == 3) { // Alumno
            // Cursos del alumno
            $cursosAlumno = $this->db->table('alumno_curso')
                ->select('idcurso')
                ->where('idusuario', $idusuario)
                ->get()
                ->getResultArray();
    
            $cursosIds = array_column($cursosAlumno, 'idcurso');
    
            $builder->groupStart()
                ->where('visibilidad', 'alumnos')
                ->groupEnd()
                ->groupStart()
                    ->whereIn('idcurso', $cursosIds)
                    ->orWhere('idcurso', null)
                ->groupEnd();
    
        } elseif ($idrol == 4) { // Profesor
            $builder->groupStart()
                // Avisos para profesores
                ->where('visibilidad', 'profesores')
                // Avisos solo creador del profesor
                ->orGroupStart()
                    ->where('visibilidad', 'solo_creador')
                    ->where('idusuario', $idusuario)
                ->groupEnd()
                // Avisos para alumnos pero creados por el mismo profesor
                ->orGroupStart()
                    ->where('visibilidad', 'alumnos')
                    ->where('idusuario', $idusuario)
                ->groupEnd()
            ->groupEnd();
        } else { // Directivo o Admin
            // ven todo dentro del colegio
        }
    
        // Filtrar por rango de fechas enviado por FullCalendar
        if ($start && $end) {
            $start = date('Y-m-d H:i:s', strtotime($start));
            $end   = date('Y-m-d H:i:s', strtotime($end));
    
            $builder->groupStart()
                ->where('fecha >=', $start)
                ->where('fecha <=', $end)
            ->groupEnd();
        }
    
        $avisos = $builder->orderBy('fecha', 'ASC')->get()->getResultArray();
    
        // Transformar a formato compatible con FullCalendar
        $eventos = [];
        foreach ($avisos as $aviso) {
            $eventos[] = [
                'id' => $aviso['idaviso'],
                'title' => $aviso['titulo'],
                'start' => date('c', strtotime($aviso['fecha'])),
                'end'   => isset($aviso['fecha_fin']) && $aviso['fecha_fin'] ? date('c', strtotime($aviso['fecha_fin'])) : null,
                'tipo'  => $aviso['visibilidad'],
                'descripcion' => $aviso['descripcion'],
            ];
        }
    
        return $this->response->setJSON($eventos);
    }
    
    public function editar($id)
{
    $avisoModel = new \App\Models\AvisoModel();
    $aviso = $avisoModel->find($id);

    if(!$aviso) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Aviso no encontrado: $id");
    }

    // Cargar vista de edición pasando los datos del aviso
    return view('avisos/editar', ['aviso' => $aviso]);
}

public function actualizar($id)
{
    $avisoModel = new \App\Models\AvisoModel();

    // Obtener fecha del input
    $fecha_input = $this->request->getPost('fecha'); // "YYYY-MM-DDTHH:MM"

    // Convertir al formato MySQL DATETIME
    $fecha = date('Y-m-d H:i:s', strtotime($fecha_input));

    $data = [
        'titulo' => $this->request->getPost('titulo'),
        'descripcion' => $this->request->getPost('descripcion'),
        'visibilidad' => $this->request->getPost('visibilidad'),
        'fecha' => $fecha
    ];

    if ($avisoModel->update($id, $data)) {
        return redirect()->to(base_url('profesor/avisos'))->with('success', 'Aviso actualizado correctamente.');
    } else {
        return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el aviso.');
    }
}
public function eliminar($id = null)
{
    $this->response->setHeader('Content-Type', 'application/json');

    if (!$id) {
        return $this->response->setJSON(['success' => false, 'message' => 'ID inválido']);
    }

    $avisosModel = new \App\Models\AvisoModel();

    if ($avisosModel->delete($id)) {
        return $this->response->setJSON(['success' => true]);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'No se pudo eliminar']);
    }
}

}
