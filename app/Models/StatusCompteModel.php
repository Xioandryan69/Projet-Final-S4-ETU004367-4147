<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusCompteModel extends Model
{
    protected $table            = 'StatusCompte';
    protected $primaryKey       = 'id';
    protected $returnType='array';
    protected $allowedFields    = ['libelle'];
}