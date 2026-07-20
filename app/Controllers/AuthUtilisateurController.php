<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\CompteModel;

class AuthUtilisateurController extends BaseController
{
    public function login()
    {
        return view('utilisateurs/login');
    }

    public function loginPost()
    {
        $numero = trim((string) $this->request->getPost('numero'));
        $motDePasse = (string) $this->request->getPost('motDePasse');

        if ($numero === '' || $motDePasse === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Le numéro et le mot de passe sont obligatoires.',
            ]);
        }

        $compteModel = new CompteModel();

        $compte = $compteModel
            ->avecDetails()
            ->where('Compte.numero', $numero)
            ->first();


        if ($compte) {

            // $motDePasseValide = password_get_info($compte['motDePasse'])['algo'] !== null
            //     ? password_verify($motDePasse, $compte['motDePasse'])
            //     : hash_equals($compte['motDePasse'], $motDePasse);

            // if (! $motDePasseValide) {
            //     return $this->response->setStatusCode(401)->setJSON([
            //         'status' => 'error',
            //         'message' => 'Mot de passe incorrect.',
            //     ]);
            // }

            session()->set([
                'compte_id' => $compte['id'],
                'numero' => $compte['numero'],
                'solde' => $compte['solde'],
                'utilisateur_id' => $compte['utilisateur_id'],
                'nom' => $compte['nom'],
                'prenom' => $compte['prenom'],
                'operateur' => $compte['operateur'],
                'typeCompte' => $compte['typeCompte'],
                'connecte' => true
            ]);


            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Connexion réussie'
            ]);
        } else {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Compte introuvable'
            ]);
        }
    }

    public function logout()
    {
        session()->destroy();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Vous êtes déconnecté.',
        ]);
    }
}
