<?php

namespace App\Controllers;

use App\Models\TransactionMobileModel;

class UtilisateurController extends BaseController
{
    public function index(): string
    {
        $compteId = session()->get('compte_id');
        $solde = $compteId ? (new TransactionMobileModel())->getSolde((int) $compteId) : 0;

        return view('utilisateurs/dashboard', ['solde' => $solde]);
    }

    public function retrait(): string
    {
        return view('utilisateurs/retrait');
    }

    public function transfert(): string
    {
        return view('utilisateurs/transfert');
    }

    public function depot(): string
    {
        return view('utilisateurs/depot');
    }

    public function transaction()
    {
        $compteId = (int) session()->get('compte_id');
        $transactionModel = new TransactionMobileModel();

        return view('utilisateurs/transaction', [
            'transactions' => $transactionModel->getHistoriqueCompte($compteId),
            'compteId' => $compteId,
        ]);
    }
}
