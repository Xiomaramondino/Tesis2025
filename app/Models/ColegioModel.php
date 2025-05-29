<?php


namespace App\Models;

use CodeIgniter\Model;

class ColegioModel extends Model
{
    protected $table      = 'colegios';   
    protected $primaryKey = 'idcolegio';        

    protected $returnType     = 'array';        
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre'];     

    
}
?>