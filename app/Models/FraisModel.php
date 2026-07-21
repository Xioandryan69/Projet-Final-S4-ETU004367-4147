<?php

namespace App\Models;

use CodeIgniter\Model;

class FraisModel extends Model
{
    protected $table = 'Frais';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'typeTransaction_id', 'relationOperateur_id', 'montantMin', 'montantMax', 'montantFrais', 'dateCreation',
    ];
    protected $validationRules = [
        'typeTransaction_id' => 'required|integer',
        'relationOperateur_id' => 'required|integer',
        'montantMin' => 'required|decimal',
        'montantMax' => 'required|decimal',
        'montantFrais' => 'required|decimal',
    ];
    protected $validationMessages = [
        'typeTransaction_id' => ['required' => 'Le type de transaction est obligatoire.', 'integer' => 'Le type de transaction est invalide.'],
        'relationOperateur_id' => ['required' => 'La relation entre opérateurs est obligatoire.', 'integer' => 'La relation entre opérateurs est invalide.'],
        'montantMin' => ['required' => 'Le montant minimum est obligatoire.', 'decimal' => 'Le montant minimum doit être un nombre valide.'],
        'montantMax' => ['required' => 'Le montant maximum est obligatoire.', 'decimal' => 'Le montant maximum doit être un nombre valide.'],
        'montantFrais' => ['required' => 'Le montant des frais est obligatoire.', 'decimal' => 'Le montant des frais doit être un nombre valide.'],
    ];

    public function withDetails(): self
    {
        return $this->select('Frais.*, TypeTransaction.libelle AS typeTransaction, RelationOperateur.libelle AS relationOperateur')
            ->join('TypeTransaction', 'TypeTransaction.id = Frais.typeTransaction_id', 'left')
            ->join('RelationOperateur', 'RelationOperateur.id = Frais.relationOperateur_id', 'left');
    }

    public function allWithDetails(): array
    {
        return $this->withDetails()->orderBy('Frais.id', 'DESC')->findAll();
    }

    public function trouverPourMontant(int $typeTransactionId, int $relationOperateurId, float $montant): ?array
    {
        return $this->where('typeTransaction_id', $typeTransactionId)
            ->where('relationOperateur_id', $relationOperateurId)
            ->where('montantMin <=', $montant)
            ->where('montantMax >=', $montant)
            ->first();
    }

    /**
     * Retourne les frais selon le préfixe du numéro destinataire.
     * Un préfixe enregistré dans PrefixeNumero est considéré comme le même
     * opérateur ; un préfixe absent applique la grille « Operateur different ».
     */
    public function getFrais(string $prefixe, int $typeTransactionId, float $montant): float
    {
        $prefixeExiste = (new PrefixeNumeroModel())
            ->where('prefixe', $prefixe)
            ->first();

        $relationLibelle = $prefixeExiste ? 'Meme operateur' : 'Operateur different';
        $relation = (new RelationOperateurModel())
            ->where('libelle', $relationLibelle)
            ->first();

        if (! $relation) {
            return 0;
        }

        $regle = $this->trouverPourMontant($typeTransactionId, (int) $relation['id'], $montant);

        return (float) ($regle['montantFrais'] ?? 0);
    }
}
