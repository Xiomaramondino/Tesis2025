<?php

namespace App\Models;

use CodeIgniter\Model;

class ExcepcionesModel extends Model
{
    protected $table            = 'excepciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'idcolegio',
        'fecha',
        'motivo'
    ];

    // Fechas
    protected $useTimestamps = false;
}
