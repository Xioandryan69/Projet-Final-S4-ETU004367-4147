<?php

namespace App\Models;

use CodeIgniter\Model;

class AdministrateurModel extends Model
{
    protected $table = 'Administrateur';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'motDePasse', 'typeOperateur_id'];
    protected $validationRules = [
        'nom' => 'required|max_length[100]',
        'prenom' => 'required|max_length[100]',
        'email' => 'required|valid_email|is_unique[Administrateur.email,id,{id}]',
        'motDePasse' => 'required|min_length[6]',
        'typeOperateur_id' => 'required|integer',
    ];
    protected $validationMessages = [
        'nom' => ['required' => 'Le nom est obligatoire.'],
        'prenom' => ['required' => 'Le prénom est obligatoire.'],
        'email' => ['required' => 'L’adresse e-mail est obligatoire.', 'valid_email' => 'L’adresse e-mail est invalide.', 'is_unique' => 'Cette adresse e-mail est déjà utilisée.'],
        'motDePasse' => ['required' => 'Le mot de passe est obligatoire.', 'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.'],
        'typeOperateur_id' => ['required' => 'Le type d’opérateur est obligatoire.', 'integer' => 'Le type d’opérateur est invalide.'],
    ];

    public function avecOperateur(): self
    {
        return $this->select('Administrateur.*, TypeOperateur.libelle AS typeOperateur')
            ->join('TypeOperateur', 'TypeOperateur.id = Administrateur.typeOperateur_id');
    }
}
