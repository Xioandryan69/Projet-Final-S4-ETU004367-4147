<?php

namespace App\Models;

use CodeIgniter\Model;

class EparneCompteModel extends Model
{
    protected $table = 'EparneCompte';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['compte_id', 'pourcentage', 'dateCreation'];


    public function getPourcentageActif($idCompte): float
    {
        $prom = $this->orderBy('id', 'DESC')->where('compte_id', $idCompte)->first();

        return (float) ($prom['pourcentage'] ?? 0);
    }
}
