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


    public function loginPost()
    {
        $data = $this->request->getPost();
        $model = new AdministrateurModel();
        $loginResult = $model->login($data['email'], $data['password']);
        $redirection = "";
        $redirection = '/admin/dashboard';



        if ($loginResult['success']) {
            return $this->response->setJSON([
                'success' => true,
                'errors' => [],
                'redirect' => $redirection
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'errors' => $loginResult['error']
        ]);
    }

    public function baremesFrais(): string 
    {
        return view('admin/baremes-frais/');
    }

    public function listComptes():string 
    {
        return view('admin/list-comptes/');
    }
    
    public function transaction():string 
    {
        return view('admin/transactions/');
    }
}