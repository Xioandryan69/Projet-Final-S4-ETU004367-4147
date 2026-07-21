<?php

namespace App\Models;

use CodeIgniter\Model;

class EparneCompteModel extends Model
{
    protected $table = 'EparneCompte';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['compte_id', 'pourcentage', 'dateCreation'];


    public function getPourcentagePourCompte(int $compteId): float
    {
        $eparne = $this->where('compte_id', $compteId)
            ->orderBy('id', 'DESC')
            ->first();

        return (float) ($eparne['pourcentage'] ?? 0);
    }
}
