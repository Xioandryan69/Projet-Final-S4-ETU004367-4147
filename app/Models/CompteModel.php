<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table = 'Compte';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'numero', 'motDePasse', 'solde', 'utilisateur_id', 'typeOperateur_id', 'typeCompte_id', 'dateCreation',
    ];
    protected $validationRules = [
        'numero' => 'required|max_length[50]|is_unique[Compte.numero,id,{id}]',
        'motDePasse' => 'required|min_length[4]',
        'solde' => 'required|decimal',
        'utilisateur_id' => 'required|integer',
        'typeOperateur_id' => 'required|integer',
        'typeCompte_id' => 'required|integer',
    ];
    protected $validationMessages = [
        'numero' => ['required' => 'Le numéro de compte est obligatoire.', 'is_unique' => 'Ce numéro de compte existe déjà.'],
        'motDePasse' => ['required' => 'Le mot de passe est obligatoire.', 'min_length' => 'Le mot de passe doit contenir au moins 4 caractères.'],
        'solde' => ['required' => 'Le solde est obligatoire.', 'decimal' => 'Le solde doit être un nombre valide.'],
        'utilisateur_id' => ['required' => 'L’utilisateur est obligatoire.', 'integer' => 'L’utilisateur est invalide.'],
        'typeOperateur_id' => ['required' => 'Le type d’opérateur est obligatoire.', 'integer' => 'Le type d’opérateur est invalide.'],
        'typeCompte_id' => ['required' => 'Le type de compte est obligatoire.', 'integer' => 'Le type de compte est invalide.'],
    ];

    public function avecDetails(): self
    {
        return $this->select('Compte.*, Utilisateur.nom, Utilisateur.prenom, TypeOperateur.libelle AS operateur, TypeCompte.libelle AS typeCompte')
            ->join('Utilisateur', 'Utilisateur.id = Compte.utilisateur_id')
            ->join('TypeOperateur', 'TypeOperateur.id = Compte.typeOperateur_id')
            ->join('TypeCompte', 'TypeCompte.id = Compte.typeCompte_id');
    }
}
