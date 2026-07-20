<?php

namespace App\Models;

use CodeIgniter\Model;

class MouvementAutreOperateurModel extends Model
{
    protected $table = 'mouvementAutreOperateur';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'typeOperateur_id',
        'numero',
        'commission',
        'montantTotal',
        'status',
        'dateCreation',
    ];
    protected $validationRules = [
        'typeOperateur_id' => 'required|integer',
        'numero' => 'required|max_length[50]|is_unique[mouvementAutreOperateur.numero,id,{id}]',
        'commission' => 'required|decimal|greater_than_equal_to[0]',
        'montantTotal' => 'required|decimal|greater_than_equal_to[0]',
        'status' => 'permit_empty|max_length[50]',
    ];
    protected $validationMessages = [
        'typeOperateur_id' => [
            'required' => 'Le type d’opérateur est obligatoire.',
            'integer' => 'Le type d’opérateur est invalide.',
        ],
        'numero' => [
            'required' => 'Le numéro est obligatoire.',
            'is_unique' => 'Ce numéro possède déjà un mouvement.',
        ],
        'commission' => [
            'required' => 'La commission est obligatoire.',
            'decimal' => 'La commission doit être un nombre valide.',
            'greater_than_equal_to' => 'La commission ne peut pas être négative.',
        ],
        'montantTotal' => [
            'required' => 'Le montant total est obligatoire.',
            'decimal' => 'Le montant total doit être un nombre valide.',
            'greater_than_equal_to' => 'Le montant total ne peut pas être négatif.',
        ],
        'status' => ['max_length' => 'Le statut ne peut pas dépasser 50 caractères.'],
    ];

    public function avecTypeOperateur(): self
    {
        return $this->select('mouvementAutreOperateur.*, TypeOperateur.libelle AS typeOperateur')
            ->join('TypeOperateur', 'TypeOperateur.id = mouvementAutreOperateur.typeOperateur_id', 'left');
    }
}
