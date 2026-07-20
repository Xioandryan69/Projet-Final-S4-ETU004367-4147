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
        $data = $this->request->getPost();

        $numero = $data['numero'];
        // $motDePasse = $data['motDePasse'];

        $compteModel = new CompteModel();

        $compte = $compteModel
            ->avecDetails()
            ->where('Compte.numero', $numero)
            ->first();


        if ($compte) {

            // // Vérification mot de passe
            // if ($motDePasse == $compte['motDePasse']) {

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
            // } else {

            //     return $this->response->setJSON([
            //         'status' => 'error',
            //         'message' => 'Mot de passe incorrect'
            //     ]);
            // }
        } else {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Compte introuvable'
            ]);
        }
    }
}
