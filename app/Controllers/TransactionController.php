<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\TransactionMobileModel;
use App\Models\TypeTransactionModel;
use App\Models\FraisModel;


class TransactionController extends BaseController
{
    public function retrait()
    {
        $montant = $this->request->getPost('montant');

        $session = session();

        $compte_id = $session->get('compte_id');


        $compteModel = new CompteModel();
        $transactionModel = new TransactionMobileModel();
        $typeTransactionModel = new TypeTransactionModel();


        // récupérer le compte
        $compte = $compteModel->find($compte_id);


        if (!$compte) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Compte introuvable'
            ]);
        }


        $fraisModel = new FraisModel();
        $frais = $fraisModel->trouverPourMontant(1, 1, $montant);

        $montantFinal = $montant + $frais;


        // vérifier solde
        if ($compte['solde'] < $montantFinal) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Solde insuffisant'
            ]);
        }


        // trouver type Retrait
        $typeRetrait = $typeTransactionModel
            ->where('libelle', 'Retrait')
            ->first();


        // diminuer solde
        $nouveauSolde = $compte['solde'] - $montantFinal;


        $compteModel->update(
            $compte_id,
            [
                'solde' => $nouveauSolde
            ]
        );


        // enregistrer transaction
        $transactionModel->insert([
            'typeTransaction_id' => $typeRetrait['id'],
            'montant' => $montant,
            'frais' => $frais,
            'montantFinal' => $montantFinal,
            'compteSource_id' => $compte_id,
            'compteDestination_id' => null,
            'raison' => 'Retrait',
            'statut' => 'Réussi'
        ]);


        // mettre à jour session
        session()->set([
            'solde' => $nouveauSolde
        ]);


        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Retrait effectué',
            'nouveauSolde' => $nouveauSolde
        ]);
    }
}
