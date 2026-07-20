<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdministrateurModel;
use App\Models\CompteModel;
use App\Models\FraisModel;
use App\Models\PrefixeNumeroModel;
use App\Models\RelationOperateurModel;
use App\Models\StatusCompteModel;
use App\Models\TransactionMobileModel;
use App\Models\TypeOperateurModel;
use App\Models\TypeTransactionModel;

class AdminController extends Controller 
{
    public function index()
    {
        return view('admin/dashboard/index');
    }

    public function validateAjax()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        $messages = [
            'email' => [
                'required' => 'L’adresse e-mail est obligatoire.',
                'valid_email' => 'L’adresse e-mail est invalide.',
            ],
            'password' => [
                'required' => 'Le mot de passe est obligatoire.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'errors' => [],
        ]);
    }

    public function login()
    {
        return view('admin/authentification/login');
    }

    public function loginPost()
    {
        $data = $this->request->getPost();
        $model = new AdministrateurModel();
        $loginResult = $model->login($data['email'], $data['password']);
        $redirection = '/admin/dashboard';

        if ($loginResult['success']) {
            return $this->response->setJSON([
                'success' => true,
                'errors' => [],
                'redirect' => $redirection,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'errors' => $loginResult['error'],
        ]);
    }

    public function baremesFrais(): string 
    {
        $typeTransactionModel = new TypeTransactionModel();
        $relationOperateurModel = new RelationOperateurModel();
        $fraisModel = new FraisModel();
        $editId = (int) $this->request->getGet('edit');
        $gains = $this->getGainsRetraitTransfert();

        return view('admin/baremes-frais/index', [
            'typeTransactions' => $typeTransactionModel->allOrdered(),
            'relations' => $relationOperateurModel->allOrdered(),
            'items' => $fraisModel->allWithDetails(),
            'current' => $editId > 0 ? $fraisModel->find($editId) : null,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
            'gains' => $gains,
            'totalGains' => array_sum(array_map(static fn (array $gain): float => (float) $gain['totalFrais'], $gains)),
        ]);
    }

    public function listComptes(): string 
    {
        $compteModel = new CompteModel();
        $statusModel = new StatusCompteModel();

        return view('admin/list-comptes/index', [
            'comptes' => $compteModel->avecDetails()->orderBy('Compte.id', 'DESC')->findAll(),
            'statuts' => $statusModel->findAll(),
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function updateStatutCompte(int $id)
    {
        $compteModel = new CompteModel();
        $statutId = (int) $this->request->getPost('idStatusCompte');

        if ($statutId <= 0 || ! $compteModel->find($id)) {
            return redirect()->to(site_url('admin/listComptes'))->with('errors', ['Compte ou statut invalide.']);
        }

        $compteModel->skipValidation(true)->update($id, ['idStatusCompte' => $statutId]);

        return redirect()->to(site_url('admin/listComptes'))->with('success', 'Statut du compte mis à jour.');
    }

    /** Affiche les opérations où le client est source ou bénéficiaire. */
    public function historiqueCompte(int $id): string
    {
        $compte = (new CompteModel())
            ->avecDetails()
            ->where('Compte.id', $id)
            ->first();

        if (! $compte) {
            return redirect()->to(site_url('admin/listComptes'))
                ->with('errors', ['Compte client introuvable.']);
        }

        return view('admin/list-comptes/historique', [
            'compte' => $compte,
            'transactions' => (new TransactionMobileModel())->getHistoriqueCompte($id),
        ]);
    }
    
    public function transaction(): string 
    {
        $transactionModel = new TransactionMobileModel();

        return view('admin/transaction/transaction', [
            'transactions' => $transactionModel->avecDetails()->orderBy('TransactionMobile.dateTransaction', 'DESC')->findAll(),
        ]);
    }

    /**
     * Situation des gains provenant exclusivement des frais de retrait et
     * de transfert. Les dépôts ne sont volontairement pas inclus.
     */
    public function gainsFrais(): string
    {
        $gains = $this->getGainsRetraitTransfert();

        $total = array_sum(array_map(
            static fn (array $gain): float => (float) $gain['totalFrais'],
            $gains
        ));

        return view('admin/gains-frais/index', [
            'gains' => $gains,
            'total' => $total,
        ]);
    }

    private function getGainsRetraitTransfert(): array
    {
        return db_connect()->query(
            "SELECT TypeTransaction.libelle AS typeTransaction,
                    COUNT(TransactionMobile.id) AS nombreOperations,
                    COALESCE(SUM(TransactionMobile.frais), 0) AS totalFrais
             FROM TypeTransaction
             LEFT JOIN TransactionMobile
                    ON TransactionMobile.typeTransaction_id = TypeTransaction.id
             WHERE LOWER(TypeTransaction.libelle) IN ('retrait', 'transfert')
             GROUP BY TypeTransaction.id, TypeTransaction.libelle
             ORDER BY TypeTransaction.libelle"
        )->getResultArray();
    }

    public function typeOperateurs(): string
    {
        $model = new TypeOperateurModel();
        $editId = (int) $this->request->getGet('edit');

        return view('admin/type-operateurs/index', [
            'items' => $model->allOrdered(),
            'current' => $editId > 0 ? $model->find($editId) : null,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function saveTypeOperateur()
    {
        $model = new TypeOperateurModel();
        $data = [
            'id' => $this->request->getPost('id') ?: null,
            'libelle' => trim((string) $this->request->getPost('libelle')),
        ];

        if (! $model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(site_url('admin/type-operateurs'))->with('success', 'Type opérateur enregistré.');
    }

    public function deleteTypeOperateur(int $id)
    {
        (new TypeOperateurModel())->delete($id);

        return redirect()->to(site_url('admin/type-operateurs'))->with('success', 'Type opérateur supprimé.');
    }

    public function prefixes(): string
    {
        $typeOperateurModel = new TypeOperateurModel();
        $prefixeModel = new PrefixeNumeroModel();
        $editId = (int) $this->request->getGet('edit');

        return view('admin/prefixes/index', [
            'typeOperateurs' => $typeOperateurModel->allOrdered(),
            'items' => $prefixeModel->allWithTypeOperateur(),
            'current' => $editId > 0 ? $prefixeModel->find($editId) : null,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function savePrefixe()
    {
        $model = new PrefixeNumeroModel();
        $data = [
            'id' => $this->request->getPost('id') ?: null,
            'prefixe' => trim((string) $this->request->getPost('prefixe')),
            'typeOperateur_id' => (int) $this->request->getPost('typeOperateur_id'),
        ];

        if (! $model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(site_url('admin/prefixes'))->with('success', 'Préfixe enregistré.');
    }

    public function deletePrefixe(int $id)
    {
        (new PrefixeNumeroModel())->delete($id);

        return redirect()->to(site_url('admin/prefixes'))->with('success', 'Préfixe supprimé.');
    }

    public function typeTransactions(): string
    {
        $model = new TypeTransactionModel();
        $editId = (int) $this->request->getGet('edit');

        return view('admin/type-transactions/index', [
            'items' => $model->allOrdered(),
            'current' => $editId > 0 ? $model->find($editId) : null,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function saveTypeTransaction()
    {
        $model = new TypeTransactionModel();
        $data = [
            'id' => $this->request->getPost('id') ?: null,
            'libelle' => trim((string) $this->request->getPost('libelle')),
        ];

        if (! $model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(site_url('admin/type-transactions'))->with('success', 'Type de transaction enregistré.');
    }

    public function deleteTypeTransaction(int $id)
    {
        (new TypeTransactionModel())->delete($id);

        return redirect()->to(site_url('admin/type-transactions'))->with('success', 'Type de transaction supprimé.');
    }

    public function relationsOperateurs(): string
    {
        $model = new RelationOperateurModel();
        $editId = (int) $this->request->getGet('edit');

        return view('admin/relation-operateurs/index', [
            'items' => $model->allOrdered(),
            'current' => $editId > 0 ? $model->find($editId) : null,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function saveRelationOperateur()
    {
        $model = new RelationOperateurModel();
        $data = [
            'id' => $this->request->getPost('id') ?: null,
            'libelle' => trim((string) $this->request->getPost('libelle')),
        ];

        if (! $model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(site_url('admin/relation-operateurs'))->with('success', 'Relation opérateur enregistrée.');
    }

    public function deleteRelationOperateur(int $id)
    {
        (new RelationOperateurModel())->delete($id);

        return redirect()->to(site_url('admin/relation-operateurs'))->with('success', 'Relation opérateur supprimée.');
    }

    public function frais(): string
    {
        $typeTransactionModel = new TypeTransactionModel();
        $relationOperateurModel = new RelationOperateurModel();
        $fraisModel = new FraisModel();
        $editId = (int) $this->request->getGet('edit');

        return view('admin/frais/index', [
            'typeTransactions' => $typeTransactionModel->allOrdered(),
            'relations' => $relationOperateurModel->allOrdered(),
            'items' => $fraisModel->allWithDetails(),
            'current' => $editId > 0 ? $fraisModel->find($editId) : null,
            'errors' => session()->getFlashdata('errors') ?? [],
            'success' => session()->getFlashdata('success'),
        ]);
    }

    public function saveFrais()
    {
        $model = new FraisModel();
        $data = [
            'id' => $this->request->getPost('id') ?: null,
            'typeTransaction_id' => (int) $this->request->getPost('typeTransaction_id'),
            'relationOperateur_id' => (int) $this->request->getPost('relationOperateur_id'),
            'montantMin' => (float) $this->request->getPost('montantMin'),
            'montantMax' => (float) $this->request->getPost('montantMax'),
            'montantFrais' => (float) $this->request->getPost('montantFrais'),
        ];

        if (! $model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(site_url('admin/frais'))->with('success', 'Barème enregistré.');
    }

    public function deleteFrais(int $id)
    {
        (new FraisModel())->delete($id);

        return redirect()->to(site_url('admin/frais'))->with('success', 'Barème supprimé.');
    }
}
