<?php
namespace App\Models;

use CodeIgniter\Model;

class DispositivoModel extends Model
{
    protected $table = 'dispositivo';
    protected $primaryKey = 'iddispositivo';
    protected $allowedFields = ['mac', 'idusuario', 'idcolegio'];

    public function getDispositivosUsuario($nombreUsuario)
{
    return $this->select('dispositivo.*')
                ->join('usuarios', 'usuarios.idusuario = dispositivo.idusuario')
                ->where('usuarios.usuario', $nombreUsuario)
                ->findAll();
}

}
?>