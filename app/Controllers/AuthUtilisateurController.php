<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthUtilisateurController extends BaseController
{
    public function login()
    {
        return view('utilisateurs/login');
    }

    public function loginPost()
    {
        $data = $this->request->getPost();
        $numero = $data['numero'];
    }
}
