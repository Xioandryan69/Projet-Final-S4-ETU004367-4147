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

    /** Enregistre ou cumule les mouvements destinés à un même numéro externe. */
    public function ajouterCommission(int $typeOperateurId, string $numero, float $commission, float $montant): bool
    {
        $mouvement = $this->where('numero', $numero)->first();

        if ($mouvement) {
            return (bool) $this->update($mouvement['id'], [
                'typeOperateur_id' => $typeOperateurId,
                'commission' => (float) $mouvement['commission'] + $commission,
                'montantTotal' => (float) $mouvement['montantTotal'] + $montant,
                'status' => 'En attente',
            ]);
        }

        return (bool) $this->insert([
            'typeOperateur_id' => $typeOperateurId,
            'numero' => $numero,
            'commission' => $commission,
            'montantTotal' => $montant,
            'status' => 'En attente',
        ]);
    }

    public function resumeParOperateur(): array
    {
        return $this->select('TypeOperateur.libelle AS operateur, COUNT(mouvementAutreOperateur.id) AS nombreMouvements, COALESCE(SUM(mouvementAutreOperateur.montantTotal), 0) AS montantTotal, COALESCE(SUM(mouvementAutreOperateur.commission), 0) AS commissionTotal')
            ->join('TypeOperateur', 'TypeOperateur.id = mouvementAutreOperateur.typeOperateur_id')
            ->groupBy('mouvementAutreOperateur.typeOperateur_id, TypeOperateur.libelle')
            ->orderBy('TypeOperateur.libelle', 'ASC')
            ->findAll();
    }

    public function allWithTypeOperateur(): array
    {
        return $this->avecTypeOperateur()
            ->orderBy('TypeOperateur.libelle', 'ASC')
            ->orderBy('mouvementAutreOperateur.dateCreation', 'DESC')
            ->findAll();
    }
}
