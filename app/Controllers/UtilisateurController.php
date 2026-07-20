<?php

namespace App\Controllers;

class UtilisateurController extends BaseController
{
    public function index(): string
    {
        return view('utilisateurs/dashboard');
    }

    public function retrait(): string
    {
        return view('utilisateurs/retrait');
    }

     public function transfert(): string
    {
        return view('utilisateurs/transfert');
    }
}
