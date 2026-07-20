<?php
namespace App\Controllers;

class RhController extends BaseController {
    public function index() {
        return view('rh/dashboard');
    }
}