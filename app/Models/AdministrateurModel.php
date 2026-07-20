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

      protected $skipValidation = false;

    public function avecOperateur(): self
    {
        return $this->select('Administrateur.*, TypeOperateur.libelle AS typeOperateur')
            ->join('TypeOperateur', 'TypeOperateur.id = Administrateur.typeOperateur_id');
    }


    public function login($email, $password)
    {
        $user = $this->where('email', $email)->first();

        if (!$user) {
            return [
                'success' => false,
                'error' => 'Email incorrect'
            ];
        }

        // if (!password_verify($password, $user['password'])) {
        if ($password !== $user['motDePasse']) {
            return [
                'success' => false,
                'error' => 'Mot de passe incorrect'
            ];
        }

        session()->set([
            'id' => $user['id'],
            'email' => $user['email'],
            'logged_in' => true,
            'admin_logged_in' => true
        ]);

        return [
            'success' => true,
            'redirect' => '/mety'
        ];
    }
}
