<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;
use App\Controllers\AdminController;
use App\Controllers\UtilisateurController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/admin/dashboard', 'AdminController::index');
$routes->get('/login', 'AuthUtilisateurController::login');

$routes->post('/login', 'AuthUtilisateurController::loginPost');
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'UtilisateurController::index');
    $routes->get('/transfert', 'UtilisateurController::transfert');
    $routes->get('/retrait', 'UtilisateurController::retrait');
    $routes->get('/transaction', 'UtilisateurController::transaction');
    $routes->get('/depot', 'UtilisateurController::depot');

    $routes->post('/logout', 'AuthUtilisateurController::logout');
    $routes->post('/retrait', 'TransactionController::retrait');
    $routes->post('/depot', 'TransactionController::depot');
    $routes->post('/transfert', 'TransactionController::transfert');
    $routes->post('/frais', 'TransactionController::frais');
});


// $routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
//     $routes->get('dashboard', 'AdminController::index');
// });
// $routes->group('rh', ['filter' => 'auth:rh'], function($routes) {
//     $routes->get('dashboard', 'RhController::index');
// });
// $routes->group('user', ['filter' => 'auth:user'], function($routes) {
//     $routes->get('dashboard', 'UserController::index');
// });
