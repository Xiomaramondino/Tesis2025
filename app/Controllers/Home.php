<?php
namespace App\Controllers;
use App\Models\Usuario; // <-- Esta línea importa el modelo

class Home extends BaseController
{
    public function index(): string
    {
        $usuarioModel = new Usuario(); // Ahora sí se puede usar
        $adminExiste = $usuarioModel->where('idrol', '1')->countAllResults() > 0;

        return view('primeravista', ['adminExiste' => $adminExiste]);
    }
}
?>