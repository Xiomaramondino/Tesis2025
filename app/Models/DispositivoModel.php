<?php
namespace App\Models;

use CodeIgniter\Model;

class DispositivoModel extends Model
{
    protected $table = 'dispositivo';
    protected $primaryKey = 'iddispositivo';
    protected $allowedFields = ['mac', 'idusuario', 'idcolegio'];
}
?>