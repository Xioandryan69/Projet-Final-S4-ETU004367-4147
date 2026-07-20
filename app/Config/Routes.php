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
    $routes->get('type-operateurs', 'AdminController::typeOperateurs');
    $routes->post('type-operateurs/save', 'AdminController::saveTypeOperateur');
    $routes->post('type-operateurs/delete/(:num)', 'AdminController::deleteTypeOperateur/$1');

    $routes->get('prefixes', 'AdminController::prefixes');
    $routes->post('prefixes/save', 'AdminController::savePrefixe');
    $routes->post('prefixes/delete/(:num)', 'AdminController::deletePrefixe/$1');

    $routes->get('type-transactions', 'AdminController::typeTransactions');
    $routes->post('type-transactions/save', 'AdminController::saveTypeTransaction');
    $routes->post('type-transactions/delete/(:num)', 'AdminController::deleteTypeTransaction/$1');

    $routes->get('relation-operateurs', 'AdminController::relationsOperateurs');
    $routes->post('relation-operateurs/save', 'AdminController::saveRelationOperateur');
    $routes->post('relation-operateurs/delete/(:num)', 'AdminController::deleteRelationOperateur/$1');

    $routes->get('frais', 'AdminController::frais');
    $routes->post('frais/save', 'AdminController::saveFrais');
    $routes->post('frais/delete/(:num)', 'AdminController::deleteFrais/$1');
    
    $routes->get('dashboard', 'AdminController::index'); 
    $routes->get('baremesFrais', 'AdminController::baremesFrais');
    $routes->get('listComptes', 'AdminController::listComptes');
    $routes->post('listComptes/statut/(:num)', 'AdminController::updateStatutCompte/$1');
    $routes->get('transaction', 'AdminController::transaction');
});