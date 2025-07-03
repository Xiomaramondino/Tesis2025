<?php
namespace App\Models;

use CodeIgniter\Model;

class SolicitudAsociacionModel extends Model
{
    protected $table = 'solicitudes_asociacion';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'usuario', 'token', 'idcolegio', 'idrol',
        'fecha_solicitud', 'confirmado', 'email_solicitante'
    ];
}
?>