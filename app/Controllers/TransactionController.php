<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\TransactionMobileModel;
use App\Models\TypeTransactionModel;
use App\Models\FraisModel;
use App\Models\StatusTransactionModel;
use App\Models\RelationOperateurModel;
use App\Models\CommissionModel;
use App\Models\MouvementAutreOperateurModel;
use App\Models\PrefixeNumeroModel;



class TransactionController extends BaseController
{
    public function frais()
    {
        $type = (string) $this->request->getPost('type');
        $montant = (float) $this->request->getPost('montant');

        if ($montant <= 0 || ! in_array($type, ['retrait', 'transfert'], true)) {
            return $this->response->setJSON(['status' => 'success', 'frais' => 0, 'montantFinal' => max(0, $montant)]);
        }

        $compte = (new CompteModel())->find((int) session()->get('compte_id'));

        if (! $compte) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Compte introuvable.',
            ]);
        }

        $frais = $type === 'transfert'
            ? $this->calculerFraisTransfert($montant, (string) $this->request->getPost('numero'))
            : $this->calculerFraisRetrait($montant);
        $versAutreOperateur = $type === 'transfert' && $this->request->getPost('autreOperateur') === '1';
        $commission = $versAutreOperateur
            ? $this->calculerCommissionAutreOperateur($montant)
            : 0;
        $fraisRetrait = $type === 'transfert' && $this->request->getPost('inclureFraisRetrait') === '1'
            ? $this->calculerFraisRetrait($montant)
            : 0;


        return $this->response->setJSON([
            'status' => 'success',
            'frais' => $frais,
            'commission' => $commission,
            'fraisRetrait' => $fraisRetrait,
            'montantFinal' => $montant + $frais + $commission + $fraisRetrait,
        ]);
    }

    public function operateurParNumero()
    {
        $numero = trim((string) $this->request->getPost('numero'));
        $prefixe = substr($numero, 0, 3);

        if ($prefixe === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Numéro invalide.',
            ]);
        }

        $operateur = (new PrefixeNumeroModel())
            ->withTypeOperateur()
            ->where('PrefixeNumero.prefixe', $prefixe)
            ->first();

        if (! $operateur) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Opérateur introuvable pour ce préfixe.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'operateur' => $operateur['typeOperateur'],
        ]);
    }

    public function transfert()
    {
        $numeroDestination = trim((string) $this->request->getPost('numero'));
        $montant = (float) $this->request->getPost('montant');
        $raison = trim((string) $this->request->getPost('raison'));
        $versAutreOperateur = $this->request->getPost('autreOperateur') === '1';
        $inclureFraisRetrait = $this->request->getPost('inclureFraisRetrait') === '1';
        $compteSourceId = (int) session()->get('compte_id');

        if ($numeroDestination === '' || $montant <= 0) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Le numéro du destinataire et un montant supérieur à zéro sont obligatoires.',
            ]);
        }

        $compteModel = new CompteModel();
        $compteSource = $compteModel->find($compteSourceId);
        $compteDestination = $compteModel->where('numero', $numeroDestination)->first();
        $typeOperateurDestinationId = null;

        if (! $compteSource) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => 'error',
                'message' => 'Veuillez vous connecter avec un compte valide.',
            ]);
        }

        if (! $versAutreOperateur && ! $compteDestination) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Le compte destinataire est introuvable.',
            ]);
        }

        if (! $versAutreOperateur && (int) $compteDestination['id'] === $compteSourceId) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Le compte destinataire doit être différent du compte source.',
            ]);
        }

        if ($versAutreOperateur) {
            $prefixe = substr($numeroDestination, 0, 3);
            $prefixeDestination = (new PrefixeNumeroModel())->where('prefixe', $prefixe)->first();

            if (! $prefixeDestination || (int) $prefixeDestination['typeOperateur_id'] === (int) $compteSource['typeOperateur_id']) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status' => 'error',
                    'message' => 'Le préfixe saisi ne correspond pas à un autre opérateur.',
                ]);
            }

            $typeOperateurDestinationId = (int) $prefixeDestination['typeOperateur_id'];
        }

        $typeTransfert = (new TypeTransactionModel())->where('libelle', 'Transfert')->first();

        if (! $typeTransfert) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Le type de transaction « Transfert » est introuvable.',
            ]);
        }

        $frais = $this->calculerFraisTransfert($montant, $numeroDestination);
        $commission = $versAutreOperateur ? $this->calculerCommissionAutreOperateur($montant) : 0;
        $fraisRetrait = $inclureFraisRetrait ? $this->calculerFraisRetrait($montant) : 0;
        $montantEnvoye = $montant + $fraisRetrait;
        $montantFinal = $montantEnvoye + $frais + $commission;
        $transactionModel = new TransactionMobileModel();

        if ($transactionModel->getSolde($compteSourceId) < $montantFinal) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Solde insuffisant.',
            ]);
        }

        $db = db_connect();
        $db->transStart();
        $transactionModel->insert([
            'typeTransaction_id' => $typeTransfert['id'],
            'montant' => $montantEnvoye,
            'frais' => $frais,
            'montantFinal' => $montantFinal,
            'compteSource_id' => $compteSourceId,
            'compteDestination_id' => $versAutreOperateur ? null : $compteDestination['id'],
            'raison' => $raison ?: ($inclureFraisRetrait ? 'Transfert externe avec frais de retrait' : ($versAutreOperateur ? 'Transfert vers autre opérateur' : 'Transfert')),
            'statutTransaction' => $this->getStatutValideId(),
        ]);

        // En mode externe, le montant remis à l'autre opérateur inclut sa commission.
        if ($versAutreOperateur) {
            (new MouvementAutreOperateurModel())->ajouterCommission(
                $typeOperateurDestinationId,
                $numeroDestination,
                $commission,
                $montantEnvoye + $commission
            );
        }

        $nouveauSoldeSource = $transactionModel->getSolde($compteSourceId);
        $compteModel->update($compteSourceId, ['solde' => $nouveauSoldeSource]);
        if (! $versAutreOperateur) {
            $nouveauSoldeDestination = $transactionModel->getSolde((int) $compteDestination['id']);
            $compteModel->update($compteDestination['id'], ['solde' => $nouveauSoldeDestination]);
        }
        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Le transfert n’a pas pu être enregistré.',
            ]);
        }

        session()->set('solde', $nouveauSoldeSource);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transfert effectué',
            'frais' => $frais,
            'commission' => $commission,
            'fraisRetrait' => $fraisRetrait,
            'nouveauSolde' => $nouveauSoldeSource,
        ]);
    }

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

        $frais = $this->calculerFraisRetrait($montant);
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

    private function calculerFraisRetrait(float $montant): float
    {
        $typeRetrait = (new TypeTransactionModel())->where('libelle', 'Retrait')->first();
        $relation = (new RelationOperateurModel())->where('libelle', 'Meme operateur')->first();

        if (! $typeRetrait || ! $relation) {
            return 0;
        }

        $regle = (new FraisModel())->trouverPourMontant($typeRetrait['id'], $relation['id'], $montant);

        return (float) ($regle['montantFrais'] ?? 0);
    }

    private function calculerFraisTransfert(float $montant, string $numeroDestination): float
    {
        $prefixe = substr(trim($numeroDestination), 0, 3);
        $typeTransfert = (new TypeTransactionModel())->where('libelle', 'Transfert')->first();

        if (! $typeTransfert || $prefixe === '') {
            return 0;
        }

        $prefixeDestination = (new PrefixeNumeroModel())->where('prefixe', $prefixe)->first();
        $compteSource = (new CompteModel())->find((int) session()->get('compte_id'));
        $memeOperateur = $prefixeDestination && $compteSource
            && (int) $prefixeDestination['typeOperateur_id'] === (int) $compteSource['typeOperateur_id'];
        $relation = (new RelationOperateurModel())
            ->where('libelle', $memeOperateur ? 'Meme operateur' : 'Operateur different')
            ->first();

        if (! $relation) {
            return 0;
        }

        $regle = (new FraisModel())->trouverPourMontant((int) $typeTransfert['id'], (int) $relation['id'], $montant);

        return (float) ($regle['montantFrais'] ?? 0);
    }

    private function calculerCommissionAutreOperateur(float $montant): float
    {
        $regle = (new CommissionModel())->orderBy('id', 'DESC')->first();
        $pourcentage = (float) ($regle['pourcentage'] ?? 0);

        return round(($pourcentage / 100) * $montant, 2);
    }
}
