<?php

namespace App\Controllers;

use App\Models\UsersModel;

class UsersController extends BaseController
{
    public function validateAjax()
    {
        $model = new UsersModel();

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

    public function inscription()
    {
        return view('inscrir');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        $data = $this->request->getPost();
        $model = new UsersModel();
        $loginResult = $model->login($data['email'], $data['password']);
        $role = $model->getRole(session()->get('id'));
        $redirection = "";

        if ($role) {
            if ($role['role_name'] == 'admin') {
                $redirection = '/admin/dashboard';
            } elseif ($role['role_name'] == 'user') {
                $redirection = '/user/dashboard';
            } elseif ($role['role_name'] == 'rh') {
                $redirection = '/rh/dashboard';
            } else {
                $redirection = 'users/logout';
            }
        }

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
}
