<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionMobileModel extends Model
{
    protected $table = 'TransactionMobile';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'typeTransaction_id', 'dateTransaction', 'montant', 'frais', 'montantFinal',
        'compteSource_id', 'compteDestination_id', 'raison', 'statut',
    ];
    protected $validationRules = [
        'typeTransaction_id' => 'required|integer',
        'montant' => 'required|decimal|greater_than[0]',
        'frais' => 'permit_empty|decimal|greater_than_equal_to[0]',
        'montantFinal' => 'required|decimal|greater_than[0]',
        'compteSource_id' => 'permit_empty|integer',
        'compteDestination_id' => 'permit_empty|integer',
        'raison' => 'permit_empty|max_length[255]',
        'statut' => 'required|in_list[VALIDE,ANNULE,EN_ATTENTE]',
    ];
    protected $validationMessages = [
        'typeTransaction_id' => ['required' => 'Le type de transaction est obligatoire.', 'integer' => 'Le type de transaction est invalide.'],
        'montant' => ['required' => 'Le montant est obligatoire.', 'decimal' => 'Le montant doit être un nombre valide.', 'greater_than' => 'Le montant doit être supérieur à zéro.'],
        'frais' => ['decimal' => 'Les frais doivent être un nombre valide.', 'greater_than_equal_to' => 'Les frais ne peuvent pas être négatifs.'],
        'montantFinal' => ['required' => 'Le montant final est obligatoire.', 'decimal' => 'Le montant final doit être un nombre valide.', 'greater_than' => 'Le montant final doit être supérieur à zéro.'],
        'compteSource_id' => ['integer' => 'Le compte source est invalide.'],
        'compteDestination_id' => ['integer' => 'Le compte destination est invalide.'],
        'statut' => ['required' => 'Le statut est obligatoire.', 'in_list' => 'Le statut est invalide.'],
    ];

    public function avecDetails(): self
    {
        return $this->select('TransactionMobile.*, TypeTransaction.libelle AS typeTransaction, source.numero AS compteSource, destination.numero AS compteDestination')
            ->join('TypeTransaction', 'TypeTransaction.id = TransactionMobile.typeTransaction_id')
            ->join('Compte AS source', 'source.id = TransactionMobile.compteSource_id', 'left')
            ->join('Compte AS destination', 'destination.id = TransactionMobile.compteDestination_id', 'left');
    }
}
