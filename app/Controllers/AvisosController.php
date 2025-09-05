<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

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

        return redirect()->to(base_url('avisos/listar'))->with('success', 'Aviso creado correctamente.');
    }

    /**
     * Listar avisos según rol y visibilidad
     */
    public function listar()
    {
        $session = session();
        $idusuario = $session->get('idusuario');
        $idcolegio = $session->get('idcolegio');
        $idrol = $session->get('idrol');

        $builder = $this->db->table('avisos');

        if ($idrol == 3) { // Alumno
            // Traer cursos del alumno
            $cursosAlumno = $this->db->table('alumno_curso')
                ->select('idcurso')
                ->where('idusuario', $idusuario)
                ->get()
                ->getResultArray();

            $cursosIds = array_column($cursosAlumno, 'idcurso');

            $builder->groupStart()
                ->whereIn('idcurso', $cursosIds)
                ->orWhere('idcurso', null)
            ->groupEnd()
            ->where('visibilidad', 'alumnos')
            ->where('idcolegio', $idcolegio);
        } elseif ($idrol == 4) { // Profesor
            $builder->groupStart()
                ->where('visibilidad', 'profesores')
                ->orGroupStart()
                    ->where('visibilidad', 'solo_creador')
                    ->where('idusuario', $idusuario)
                ->groupEnd()
            ->groupEnd()
            ->where('idcolegio', $idcolegio);
        } else { // Directivo o Admin
            $builder->where('idcolegio', $idcolegio);
        }

        $avisos = $builder->orderBy('fecha', 'DESC')->get()->getResult();

        return view('avisos/listar', ['avisos' => $avisos]);
    }
}
