<?php
namespace App\Controllers;
use App\Models\Usuario; // <-- Esta línea importa el modelo

class Home extends BaseController
{
    public function index(): string
    {
        return view('primeravista');
    }
}
?>