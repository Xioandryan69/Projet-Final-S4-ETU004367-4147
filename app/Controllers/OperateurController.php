<?php

namespace App\Controllers;

use App\Models\AdministrateurModel;
use App\Models\FraisModel;
use App\Models\PrefixeNumeroModel;
use App\Models\RelationOperateurModel;
use App\Models\TypeTransactionModel;

class OperateurController extends BaseController
{
    public function login()
    {
        return view('operateur/login');
    }

    public function loginPost()
    {
        $email = trim((string) $this->request->getPost('email'));
        $motDePasse = (string) $this->request->getPost('motDePasse');
        $administrateur = (new AdministrateurModel())->avecOperateur()->where('Administrateur.email', $email)->first();

        $valide = $administrateur && (password_get_info($administrateur['motDePasse'])['algo'] !== null
            ? password_verify($motDePasse, $administrateur['motDePasse'])
            : hash_equals($administrateur['motDePasse'], $motDePasse));

        if (! $valide) {
            return redirect()->back()->withInput()->with('error', 'Identifiants opérateur incorrects.');
        }

        session()->set([
            'operateur_connecte' => true,
            'operateur_id' => $administrateur['id'],
            'operateur_type_id' => $administrateur['typeOperateur_id'],
            'operateur_nom' => $administrateur['nom'] . ' ' . $administrateur['prenom'],
            'operateur_libelle' => $administrateur['typeOperateur'],
        ]);

        return redirect()->to('/operateur');
    }

    public function logout()
    {
        session()->remove(['operateur_connecte', 'operateur_id', 'operateur_type_id', 'operateur_nom', 'operateur_libelle']);

        return redirect()->to('/operateur/login');
    }

    public function index()
    {
        $typeOperateurId = (int) session()->get('operateur_type_id');
        $db = db_connect();

        $frais = (new FraisModel())
            ->select('Frais.*, TypeTransaction.libelle AS typeTransaction, RelationOperateur.libelle AS relationOperateur')
            ->join('TypeTransaction', 'TypeTransaction.id = Frais.typeTransaction_id')
            ->join('RelationOperateur', 'RelationOperateur.id = Frais.relationOperateur_id')
            ->orderBy('TypeTransaction.libelle')
            ->orderBy('Frais.montantMin')
            ->findAll();

        $gains = $db->query(
            "SELECT TypeTransaction.libelle AS typeTransaction, COALESCE(SUM(TransactionMobile.frais), 0) AS totalFrais
             FROM TransactionMobile
             JOIN TypeTransaction ON TypeTransaction.id = TransactionMobile.typeTransaction_id
             JOIN Compte ON Compte.id = TransactionMobile.compteSource_id
             WHERE Compte.typeOperateur_id = ? AND TypeTransaction.libelle IN ('Retrait', 'Transfert')
             GROUP BY TypeTransaction.id, TypeTransaction.libelle",
            [$typeOperateurId]
        )->getResultArray();

        $clients = $db->query(
            "SELECT Compte.numero, Compte.solde, Compte.dateCreation, Utilisateur.nom, Utilisateur.prenom, TypeCompte.libelle AS typeCompte
             FROM Compte
             JOIN Utilisateur ON Utilisateur.id = Compte.utilisateur_id
             JOIN TypeCompte ON TypeCompte.id = Compte.typeCompte_id
             WHERE Compte.typeOperateur_id = ?
             ORDER BY Compte.id DESC",
            [$typeOperateurId]
        )->getResultArray();

        return view('operateur/dashboard', [
            'prefixes' => (new PrefixeNumeroModel())->where('typeOperateur_id', $typeOperateurId)->findAll(),
            'typesTransaction' => (new TypeTransactionModel())->findAll(),
            'relations' => (new RelationOperateurModel())->findAll(),
            'frais' => $frais,
            'gains' => $gains,
            'clients' => $clients,
        ]);
    }

    public function ajouterPrefixe()
    {
        $model = new PrefixeNumeroModel();
        $model->insert([
            'prefixe' => trim((string) $this->request->getPost('prefixe')),
            'typeOperateur_id' => (int) session()->get('operateur_type_id'),
        ]);

        return redirect()->to('/operateur')->with($model->errors() ? 'error' : 'success', $model->errors() ? implode(' ', $model->errors()) : 'Préfixe ajouté.');
    }

    public function ajouterTypeTransaction()
    {
        $model = new TypeTransactionModel();
        $model->insert(['libelle' => trim((string) $this->request->getPost('libelle'))]);

        return redirect()->to('/operateur')->with($model->errors() ? 'error' : 'success', $model->errors() ? implode(' ', $model->errors()) : 'Type d’opération ajouté.');
    }

    public function enregistrerFrais()
    {
        $model = new FraisModel();
        $id = (int) $this->request->getPost('id');
        $data = [
            'typeTransaction_id' => (int) $this->request->getPost('typeTransaction_id'),
            'relationOperateur_id' => (int) $this->request->getPost('relationOperateur_id'),
            'montantMin' => (float) $this->request->getPost('montantMin'),
            'montantMax' => (float) $this->request->getPost('montantMax'),
            'montantFrais' => (float) $this->request->getPost('montantFrais'),
        ];

        $id > 0 ? $model->update($id, $data) : $model->insert($data);

        return redirect()->to('/operateur')->with($model->errors() ? 'error' : 'success', $model->errors() ? implode(' ', $model->errors()) : 'Barème enregistré.');
    }
}
