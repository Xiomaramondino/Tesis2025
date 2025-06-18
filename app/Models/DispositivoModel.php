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
public function getDispositivosConColegio($idusuario)
{
    return $this->select('dispositivo.*, colegios.nombre AS nombre_colegio')
        ->join('colegios', 'colegios.idcolegio = dispositivo.idcolegio')
        ->where('dispositivo.idusuario', $idusuario)
        ->findAll();
}
}
?>