<?php namespace App\Models;

use CodeIgniter\Model;

class AdminAceptadosModel extends Model
{
    protected $table = 'admin_aceptados';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idusuario', 'idcolegio', 'fecha_aceptacion'];
}
