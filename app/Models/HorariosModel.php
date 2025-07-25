<?php

// app/Models/HorariosModel.php

namespace App\Models;

use CodeIgniter\Model;

class HorariosModel extends Model
{
    protected $table = 'horarios';
    protected $allowedFields = ['evento','hora','idcolegio','iddia']; 
    protected $defaults = ['hora' => '00:00:00']; 
    protected $primaryKey = 'idhorario';
    
    public function getAllHorarios()
    {
        return $this->orderBy('hora', 'ASC')->findAll();
    }

    public function updateHorario($idhorario, $data)
    {
        return $this->update($idhorario, $data);
    }

    public function deleteHorario($idhorario)
    {
        return $this->delete($idhorario);
    }
    public function getHorario($idhorario)
    {
        return $this->where('idhorario', $idhorario)->first();
    }
}
?>