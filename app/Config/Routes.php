<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;
use App\Controllers\AdminController;
use App\Controllers\UtilisateurController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UtilisateurController::index');
$routes->get('/admin/dashboard', 'AdminController::index');
$routes->get('/', 'UtilisateurController::index');
$routes->get('/transfert', 'UtilisateurController::transfert');
$routes->get('/retrait', 'UtilisateurController::retrait');
$routes->get('/transaction', 'UtilisateurController::transaction');
$routes->get('/depot', 'UtilisateurController::depot');
$routes->get('/depot', 'UtilisateurController::depot');
$routes->get('/login', 'AuthUtilisateurController::login');

$routes->post('/login', 'AuthUtilisateurController::loginPost');
$routes->get('/admin/login', 'AdminController::login');
$routes->post('/admin/login', 'AdminController::loginPost');
$routes->post('/admin/validateAjax', 'AdminController::validateAjax');
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    
    $routes->get('dashboard', 'AdminController::index'); 
    $routes->get('baremesFrais', 'AdminController::baremesFrais');
    $routes->get('listComptes', 'AdminController::listComptes');
    $routes->get('transaction', 'AdminController::transaction');
});
