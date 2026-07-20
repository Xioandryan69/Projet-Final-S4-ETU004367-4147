<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AdministrateurModel;

class AdminController extends Controller 
{

        public function validateAjax()
    {
        $model = new AdministrateurModel();

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

    public function login()
    {
        return view('admin/authentification/login');
    }

    public function baremesFrais(): string 
    {
        return view('admin/baremes-frais/');
    }
}