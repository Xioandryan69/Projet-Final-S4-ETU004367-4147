<?php

namespace App\Controllers;

use App\Models\PromModel;

class PromController extends BaseController
{
    public function index()
    {
        $promModel = new PromModel();

        $data = [
            'promotions' => $promModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('utilisateurs/prom/index', $data);
    }

    public function create()
    {
        return view('utilisateurs/prom/create');
    }

    public function store()
    {
        $promModel = new PromModel();

        $data = [
            'pourcentage' => (float) $this->request->getPost('pourcentage'),
        ];

        if (! $promModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $promModel->errors());
        }

        $promModel->insert($data);

        return redirect()->to('/prom')->with('success', 'Promotion ajoutée avec succès.');
    }

    public function edit($id)
    {
        $promModel = new PromModel();
        $promotion = $promModel->find((int) $id);

        if (! $promotion) {
            return redirect()->to('/prom')->with('error', 'Promotion introuvable.');
        }

        return view('utilisateurs/prom/edit', ['promotion' => $promotion]);
    }

    public function update($id)
    {
        $promModel = new PromModel();
        $promotion = $promModel->find((int) $id);

        if (! $promotion) {
            return redirect()->to('/prom')->with('error', 'Promotion introuvable.');
        }

        $data = [
            'pourcentage' => (float) $this->request->getPost('pourcentage'),
        ];

        if (! $promModel->validate($data)) {
            return redirect()->back()->withInput()->with('errors', $promModel->errors());
        }

        $promModel->update((int) $id, $data);

        return redirect()->to('/prom')->with('success', 'Promotion mise à jour avec succès.');
    }

    public function delete($id)
    {
        $promModel = new PromModel();
        $promotion = $promModel->find((int) $id);

        if (! $promotion) {
            return redirect()->to('/prom')->with('error', 'Promotion introuvable.');
        }

        $promModel->delete((int) $id);

        return redirect()->to('/prom')->with('success', 'Promotion supprimée avec succès.');
    }
}
