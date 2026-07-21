<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'Utilisateur';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'cin', 'dateCreation'];
    protected $validationRules = [
        'nom' => 'required|max_length[100]',
        'prenom' => 'required|max_length[100]',
        'cin' => 'required|max_length[50]|is_unique[Utilisateur.cin,id,{id}]',
    ];
    protected $validationMessages = [
        'nom' => ['required' => 'Le nom est obligatoire.'],
        'prenom' => ['required' => 'Le prénom est obligatoire.'],
        'cin' => ['required' => 'Le CIN est obligatoire.', 'is_unique' => 'Ce CIN est déjà utilisé.'],
    ];
}
