<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;
use App\Controllers\AdminController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/admin/dashboard','AdminController::index');


// $routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
//     $routes->get('dashboard', 'AdminController::index');
// });
// $routes->group('rh', ['filter' => 'auth:rh'], function($routes) {
//     $routes->get('dashboard', 'RhController::index');
// });
// $routes->group('user', ['filter' => 'auth:user'], function($routes) {
//     $routes->get('dashboard', 'UserController::index');
// });
