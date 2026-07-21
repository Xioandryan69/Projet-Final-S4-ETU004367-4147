<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneMouvementModel extends Model
{
    protected $table = 'EpargneMouvement';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['compte_id', 'montant', 'raison', 'dateCreation'];

    protected $validationRules = [
        'compte_id' => 'required|integer',
        'montant' => 'required|decimal|greater_than_equal_to[0]',
    ];

    /**
     * Crédite le compte épargne d'un montant (mouvement automatique par exemple).
     */
    public function crediter(int $compteId, float $montant, string $raison = 'Épargne automatique'): void
    {
        if ($montant <= 0) {
            return;
        }

        $this->insert([
            'compte_id' => $compteId,
            'montant' => $montant,
            'raison' => $raison,
        ]);
    }

    /**
     * Retourne le solde total épargné pour un compte.
     */
    public function getSoldeEpargne(int $compteId): float
    {
        $resultat = $this->selectSum('montant')
            ->where('compte_id', $compteId)
            ->first();

        return (float) ($resultat['montant'] ?? 0);
    }
}
