<?php
namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'idcurso';
    protected $allowedFields = ['idcolegio', 'nombre', 'division'];
}
