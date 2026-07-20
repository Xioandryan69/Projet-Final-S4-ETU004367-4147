<?php

namespace App\Controllers;

class UtilisateurController extends BaseController
{
    public function index(): string
    {
        return view('utilisateurs/dashboard');
    }
}
