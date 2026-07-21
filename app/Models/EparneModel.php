<?php

namespace App\Models;

use CodeIgniter\Model;

class PromModel extends Model
{
    protected $table = 'eparne';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['pourcentage', 'dateCreation'];

    protected $validationRules = [
        'pourcentage' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
    ];
    protected $validationMessages = [
        'pourcentage' => [
            'required' => 'Le pourcentage de la eparne est obligatoire.',
            'decimal' => 'Le pourcentage doit être un nombre valide.',
            'greater_than_equal_to' => 'Le pourcentage ne peut pas être négatif.',
            'less_than_equal_to' => 'Le pourcentage ne peut pas dépasser 100.',
        ],
    ];

    /**
     * Retourne le pourcentage de la promotion active (la plus récemment créée).
     * Si aucune promotion n'existe, retourne 0 (aucune réduction).
     */
    public function getPourcentageActif(): float
    {
        $prom = $this->orderBy('id', 'DESC')->first();

        return (float) ($prom['pourcentage'] ?? 0);
    }
}
