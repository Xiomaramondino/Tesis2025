<?php

namespace App\Models;

use CodeIgniter\Model;

class EventosEspecialesModel extends Model
{
    protected $table            = 'eventos_especiales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'object'; // también puede ser 'array'
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'idcolegio',
        'fecha',
        'hora',
        'descripcion',
        'activo'
    ];

    // Fechas
    protected $useTimestamps = false; // tu tabla no tiene created_at ni updated_at
}
