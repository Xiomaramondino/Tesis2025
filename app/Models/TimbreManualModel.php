<?php
namespace App\Models;

use CodeIgniter\Model;

class TimbreManualModel extends Model
{
    protected $table = 'timbre_manual';
    protected $primaryKey = 'id';
    protected $allowedFields = ['mac', 'pendiente', 'timestamp'];
}
?>