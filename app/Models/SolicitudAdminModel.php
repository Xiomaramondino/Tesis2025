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
        'fecha_solicitud'
    ];

    protected $useTimestamps = false; // ya tenemos fecha_solicitud con default CURRENT_TIMESTAMP

    // Opcional: agregar funciones útiles
    /**
     * Obtener solicitudes pendientes de un colegio
     */
    public function obtenerPendientesPorColegio($idcolegio)
    {
        return $this->where('idcolegio', $idcolegio)
                    ->where('estado', 'pendiente')
                    ->orderBy('fecha_solicitud', 'ASC')
                    ->findAll();
    }

    /**
     * Cambiar estado de solicitud (aceptada o rechazada)
     */
    public function actualizarEstado($idSolicitud, $estado)
    {
        return $this->update($idSolicitud, ['estado' => $estado]);
    }

    /**
     * Eliminar solicitudes pendientes antiguas (por ejemplo >48h)
     */
    public function eliminarPendientesAntiguas()
    {
        $fechaLimite = date('Y-m-d H:i:s', strtotime('-48 hours'));
        return $this->where('estado', 'pendiente')
                    ->where('fecha_solicitud <', $fechaLimite)
                    ->delete();
    }
}
