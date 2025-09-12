<?php

namespace App\Models;

use CodeIgniter\Model;

class AvisoModel extends Model
{
    protected $table = 'avisos';
    protected $primaryKey = 'idaviso';
    protected $allowedFields = [
        'idcolegio',
        'idcurso',
        'idusuario',
        'titulo',
        'descripcion',
        'fecha',
        'visibilidad'
    ];
}
