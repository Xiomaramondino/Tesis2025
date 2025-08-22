<?php

namespace App\Models;

use CodeIgniter\Model;

class ExcepcionesModel extends Model
{
    protected $table            = 'excepciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'object'; 
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'idcolegio',
        'fecha',
        'motivo'
    ];

    // Fechas
    protected $useTimestamps = false;
}
