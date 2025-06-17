<?php
// App\Models\UsuarioColegio.php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioColegioModel extends Model
{
    protected $table      = 'usuario_colegio';
    protected $primaryKey = 'idusuario_colegio';
    protected $allowedFields = ['idusuario', 'idcolegio', 'idrol'];
}
?>