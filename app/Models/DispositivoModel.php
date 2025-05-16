<?php

namespace App\Models;

use CodeIgniter\Model;

class DispositivoModel extends Model
{
    protected $table      = 'dispositivo';
    protected $primaryKey = 'iddispositivo';

    protected $allowedFields = ['colegio'];

    // Opcional: para usar timestamps automáticos si los tienes
    // protected $useTimestamps = true;
    
}
?>