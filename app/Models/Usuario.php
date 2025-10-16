<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'idusuario';
    protected $allowedFields = ['usuario', 'email', 'password', 'token','iddispositivo','fecha_registro', 'token_expira'];

    // Hash password before inserting or updating
    public function beforeInsert(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function beforeUpdate(array $data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
    }

    public function exists($where)
    {
        return $this->where($where)->countAllResults() > 0;
    }
    

    public function existenteEmail($email)
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
   public function insertarUsuario($array)
    {
        // Intentar insertar los datos y registrar el resultado
        $result = $this->insert($array);
        
        return $result;
    }
    
    public function obtenerUsuarioEmail($email)
{
    return $this->where('email', $email)->first();
}

public function existeLectorConEmail($email)
{
    return $this->where('email', $email)
                ->where('idrol', 3)
                ->first();
}


}
?>