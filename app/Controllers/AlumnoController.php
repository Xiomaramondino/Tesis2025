<?php

namespace App\Controllers;

class AlumnoController extends BaseController
{
    public function calendario()
    {
        // Puedes cargar datos si es necesario, ahora solo mostramos la vista
        return view('calendario_alumno');
    }
}
