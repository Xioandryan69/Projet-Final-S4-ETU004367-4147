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

    public function depot(): string
    {
        return view('utilisateurs/depot');
    }

    public function transaction(): string
    {
        return view('utilisateurs/transaction');
    }
}
