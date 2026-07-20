<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class AdminController extends Controller 
{
    public function index(): string 
    {
        return view('admin/authentification/index');
    }
}