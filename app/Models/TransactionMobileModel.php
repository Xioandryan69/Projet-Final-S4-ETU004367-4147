<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionMobileModel extends Model
{
    protected $table = 'TransactionMobile';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'typeTransaction_id',
        'dateTransaction',
        'montant',
        'frais',
        'montantFinal',
        'compteSource_id',
        'compteDestination_id',
        'raison',
        'statutTransaction',
    ];
    protected $validationRules = [
        'typeTransaction_id' => 'required|integer',
        'montant' => 'required|numeric|greater_than[0]',
        'frais' => 'permit_empty|numeric|greater_than_equal_to[0]',
        'montantFinal' => 'required|numeric|greater_than[0]',
        'compteSource_id' => 'permit_empty|integer',
        'compteDestination_id' => 'permit_empty|integer',
        'raison' => 'permit_empty|max_length[255]',
        'statutTransaction' => 'required|integer',
    ];
    protected $validationMessages = [
        'typeTransaction_id' => ['required' => 'Le type de transaction est obligatoire.', 'integer' => 'Le type de transaction est invalide.'],
        'montant' => ['required' => 'Le montant est obligatoire.', 'numeric' => 'Le montant doit être un nombre valide.', 'greater_than' => 'Le montant doit être supérieur à zéro.'],
        'frais' => ['numeric' => 'Les frais doivent être un nombre valide.', 'greater_than_equal_to' => 'Les frais ne peuvent pas être négatifs.'],
        'montantFinal' => ['required' => 'Le montant final est obligatoire.', 'numeric' => 'Le montant final doit être un nombre valide.', 'greater_than' => 'Le montant final doit être supérieur à zéro.'],
        'compteSource_id' => ['integer' => 'Le compte source est invalide.'],
        'compteDestination_id' => ['integer' => 'Le compte destination est invalide.'],
        'statutTransaction' => ['required' => 'Le statut est obligatoire.'],
    ];

    public function avecDetails(): self
    {
        return $this->select('TransactionMobile.*, TypeTransaction.libelle AS typeTransaction, source.numero AS compteSource, destination.numero AS compteDestination, StatusTransaction.libelle AS statut')
            ->join('TypeTransaction', 'TypeTransaction.id = TransactionMobile.typeTransaction_id')
            ->join('Compte AS source', 'source.id = TransactionMobile.compteSource_id', 'left')
            ->join('Compte AS destination', 'destination.id = TransactionMobile.compteDestination_id', 'left')
            ->join('StatusTransaction', 'StatusTransaction.id = TransactionMobile.statutTransaction', 'left');
    }

    public function getSolde(int $compteId): float
    {
        $resultat = $this->db->query(
            "SELECT COALESCE(SUM(
            CASE

                -- Dépôt reçu
                WHEN TypeTransaction.libelle = 'Depot'
                     AND (TransactionMobile.compteDestination_id = ?
                          OR TransactionMobile.compteSource_id = ?)
                    THEN TransactionMobile.montant


                -- Transfert reçu
                WHEN TypeTransaction.libelle = 'Transfert'
                     AND TransactionMobile.compteDestination_id = ?
                    THEN TransactionMobile.montant


                -- Retrait effectué
                WHEN TypeTransaction.libelle = 'Retrait'
                     AND TransactionMobile.compteSource_id = ?
                    THEN -TransactionMobile.montantFinal


                -- Transfert envoyé
                WHEN TypeTransaction.libelle = 'Transfert'
                     AND TransactionMobile.compteSource_id = ?
                    THEN -TransactionMobile.montantFinal


                ELSE 0

            END
        ), 0) AS solde

        FROM TransactionMobile

        INNER JOIN TypeTransaction
            ON TypeTransaction.id = TransactionMobile.typeTransaction_id",

            [
                $compteId,
                $compteId,
                $compteId,
                $compteId,
                $compteId
            ]

        )->getRowArray();


        return (float) $resultat['solde'];
    }
}
