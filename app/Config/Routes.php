<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UtilisateurController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UtilisateurController::index');
$routes->get('/transfert', 'UtilisateurController::transfert');
$routes->get('/retrait', 'UtilisateurController::retrait');
$routes->get('/transaction', 'UtilisateurController::transaction');
$routes->get('/depot', 'UtilisateurController::depot');
$routes->get('/depot', 'UtilisateurController::depot');
$routes->get('/login', 'AuthUtilisateurController::login');


// $routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
//     $routes->get('dashboard', 'AdminController::index');
// });
// $routes->group('rh', ['filter' => 'auth:rh'], function($routes) {
//     $routes->get('dashboard', 'RhController::index');
// });
// $routes->group('user', ['filter' => 'auth:user'], function($routes) {
//     $routes->get('dashboard', 'UserController::index');
// });
