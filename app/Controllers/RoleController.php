<?php

namespace App\Controllers;

use App\Models\RoleModel;

class RoleController extends BaseController
{
    public function create()
    {
        $model = new RoleModel();

        $data = $this->request->getPost();

        if (!$model->validate($data)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $model->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'errors' => []
        ]);
    }
    public function index()
    {
        return view('role/index'); // Va chercher le fichier dans app/Views/role/index.php
    }
}