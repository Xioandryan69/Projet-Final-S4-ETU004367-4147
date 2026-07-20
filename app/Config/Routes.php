<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UsersController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('users/validate', 'UsersController::validateAjax');
$routes->get('/inscription', 'UsersController::inscription');
$routes->get('role/', 'RoleController::index');
$routes->post('role/create', 'RoleController::create');
$routes->get('users/login', 'UsersController::login');
$routes->post('users/login', 'UsersController::loginPost');



$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::index');
});
$routes->group('rh', ['filter' => 'auth:rh'], function($routes) {
    $routes->get('dashboard', 'RhController::index');
});
$routes->group('user', ['filter' => 'auth:user'], function($routes) {
    $routes->get('dashboard', 'UserController::index');
});
