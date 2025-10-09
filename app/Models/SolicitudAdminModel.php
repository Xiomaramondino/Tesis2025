<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitudAdminModel extends Model
{
    protected $table = 'solicitudes_admin';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'idusuario',
        'idcolegio',
        'producto',
        'paypal_order_id',
        'payment_status',
        'estado',
        'email',
        'fecha_solicitud'
    ];

    protected $useTimestamps = false; 
    
    public function obtenerPendientesPorColegio($idcolegio)
    {
        return $this->where('idcolegio', $idcolegio)
                    ->where('estado', 'pendiente')
                    ->orderBy('fecha_solicitud', 'ASC')
                    ->findAll();
    }


    public function actualizarEstado($idSolicitud, $estado)
    {
        return $this->update($idSolicitud, ['estado' => $estado]);
    }

    public function eliminarPendientesAntiguas()
    {
        $fechaLimite = date('Y-m-d H:i:s', strtotime('-48 hours'));
        return $this->where('estado', 'pendiente')
                    ->where('fecha_solicitud <', $fechaLimite)
                    ->delete();
    }
}
