<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\TransactionMobileModel;
use App\Models\TypeTransactionModel;
use App\Models\FraisModel;
use App\Models\StatusTransactionModel;


class TransactionController extends BaseController
{
    public function depot()
    {
        $montant = (float) $this->request->getPost('montant');
        $compteId = (int) session()->get('compte_id');

        if ($montant <= 0) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Le montant doit être supérieur à zéro.',
            ]);
        }

        $compteModel = new CompteModel();
        $compte = $compteModel->find($compteId);

        if (! $compte) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Veuillez vous connecter avec un compte valide.',
            ]);
        }

        $typeDepot = (new TypeTransactionModel())->where('libelle', 'Depot')->first();

        if (! $typeDepot) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Le type de transaction « Depot » est introuvable.',
            ]);
        }

        $transactionModel = new TransactionMobileModel();
        $transactionModel->insert([
            'typeTransaction_id' => $typeDepot['id'],
            'montant' => $montant,
            'frais' => 0,
            'montantFinal' => $montant,
            'compteSource_id' => null,
            'compteDestination_id' => $compteId,
            'raison' => 'Dépôt',
            'statutTransaction' => $this->getStatutValideId(),
        ]);

        $nouveauSolde = $transactionModel->getSolde($compteId);
        $compteModel->update($compteId, ['solde' => $nouveauSolde]);
        session()->set('solde', $nouveauSolde);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Dépôt effectué',
            'nouveauSolde' => $nouveauSolde,
        ]);
    }

    public function retrait()
    {
        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Le montant doit être supérieur à zéro.',
            ]);
        }

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


        $typeRetrait = $typeTransactionModel->where('libelle', 'Retrait')->first();

        if (! $typeRetrait) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Le type de transaction « Retrait » est introuvable.',
            ]);
        }

        $fraisModel = new FraisModel();
        $regleFrais = $fraisModel->trouverPourMontant($typeRetrait['id'], 1, $montant);
        $frais = (float) ($regleFrais['montantFrais'] ?? 0);
        $montantFinal = $montant + $frais;
        $soldeActuel = $transactionModel->getSolde((int) $compte_id);


        // vérifier solde
        if ($soldeActuel < $montantFinal) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Solde insuffisant'
            ]);
        }



        // enregistrer transaction
        $transactionModel->insert([
            'typeTransaction_id' => $typeRetrait['id'],
            'montant' => $montant,
            'frais' => $frais,
            'montantFinal' => $montantFinal,
            'compteSource_id' => $compte_id,
            'compteDestination_id' => null,
            'raison' => 'Retrait',
            'statutTransaction' => $this->getStatutValideId(),
        ]);

        $nouveauSolde = $transactionModel->getSolde((int) $compte_id);
        $compteModel->update($compte_id, ['solde' => $nouveauSolde]);


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

    private function getStatutValideId(): int
    {
        $statusTransactionModel = new StatusTransactionModel();
        $statutValide = $statusTransactionModel->where('libelle', 'VALIDE')->first();

        return $statutValide
            ? (int) $statutValide['id']
            : (int) $statusTransactionModel->insert(['libelle' => 'VALIDE']);
    }
}
