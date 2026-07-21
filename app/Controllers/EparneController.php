<?php

namespace App\Controllers;

use App\Models\EparneCompteModel;
use App\Models\EpargneMouvementModel;

class EparneController extends BaseController
{
    public function index()
    {
        $eparneCompteModel = new EparneCompteModel();

        $data = [
            'promotions' => $eparneCompteModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('utilisateurs/eparne/eplist', $data);
    }

    public function create()
    {
        return view('utilisateurs/eparne/create');
    }

    public function store()
    {
        $eparneCompteModel = new EparneCompteModel();
        $compteId = (int) session()->get('compte_id');

        $data = [
            'pourcentage' => (float) $this->request->getPost('pourcentage'),
            'compte_id' => $compteId,
        ];

        if (! $eparneCompteModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $eparneCompteModel->errors());
        }

        $eparneCompteModel->insert($data);

        return redirect()->to('/eparne')->with('success', 'Promotion ajoutée avec succès.');
    }

    public function edit($id)
    {
        $eparneCompteModel = new EparneCompteModel();
        $eparne = $eparneCompteModel->find((int) $id);

        if (! $eparne) {
            return redirect()->to('/eparne')->with('error', 'Promotion introuvable.');
        }

        return view('utilisateurs/eparne/edit', ['promotion' => $eparne]);
    }

    public function update($id)
    {
        $eparneCompteModel = new EparneCompteModel();
        $eparne = $eparneCompteModel->find((int) $id);

        if (! $eparne) {
            return redirect()->to('/eparne')->with('error', 'Promotion introuvable.');
        }

        $data = [
            'pourcentage' => (float) $this->request->getPost('pourcentage'),
        ];

        if (! $eparneCompteModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $eparneCompteModel->errors());
        }

        $eparneCompteModel->update((int) $id, $data);

        return redirect()->to('/eparne')->with('success', 'Promotion mise à jour avec succès.');
    }

    public function delete($id)
    {
        $eparneCompteModel = new EparneCompteModel();
        $eparne = $eparneCompteModel->find((int) $id);

        if (! $eparne) {
            return redirect()->to('/eparne')->with('error', 'Promotion introuvable.');
        }

        $eparneCompteModel->delete((int) $id);

        return redirect()->to('/eparne')->with('success', 'Promotion supprimée avec succès.');
    }
    public function mouvements()
    {
        $compteId = (int) session()->get('compte_id');

        if (! $compteId) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $epargneMouvementModel = new EpargneMouvementModel();

        $data = [
            'mouvements' => $epargneMouvementModel->getHistoriqueCompte($compteId),
            'soldeEpargne' => $epargneMouvementModel->getSoldeEpargne($compteId),
        ];

        return view('utilisateurs/eparne/mouvements', $data);
    }
}
