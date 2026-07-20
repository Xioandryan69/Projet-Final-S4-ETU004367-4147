<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusTransactionModel extends Model
{
    protected $table            = 'StatusTransaction';
    protected $primaryKey       = 'id';
    protected $returnType='array';
    protected $allowedFields    = ['libelle'];
}