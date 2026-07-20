<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================================================
// Authentification utilisateur
// ======================================================

$routes->get('/login', 'AuthUtilisateurController::login');
$routes->post('/login', 'AuthUtilisateurController::loginPost');

$routes->get('/operateur/login', 'OperateurController::login');
$routes->post('/operateur/login', 'OperateurController::loginPost');

// ======================================================
// Authentification administrateur
// ======================================================

$routes->get('/admin/login', 'AdminController::login');
$routes->post('/admin/login', 'AdminController::loginPost');
$routes->post('/admin/validateAjax', 'AdminController::validateAjax');

// ======================================================
// Utilisateur connecté
// ======================================================

$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'UtilisateurController::index');

    $routes->get('/transfert', 'UtilisateurController::transfert');
    $routes->get('/retrait', 'UtilisateurController::retrait');
    $routes->get('/depot', 'UtilisateurController::depot');
    $routes->get('/transaction', 'UtilisateurController::transaction');

    $routes->post('/transfert', 'TransactionController::transfert');
    $routes->post('/retrait', 'TransactionController::retrait');
    $routes->post('/depot', 'TransactionController::depot');
    $routes->post('/frais', 'TransactionController::frais');

    $routes->post('/logout', 'AuthUtilisateurController::logout');
});

// ======================================================
// Administration
// ======================================================

$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'AdminController::index');

    // Comptes
    $routes->get('listComptes', 'AdminController::listComptes');
    $routes->post('listComptes/statut/(:num)', 'AdminController::updateStatutCompte/$1');

    // Transactions
    $routes->get('transaction', 'AdminController::transaction');

    // Barèmes
    $routes->get('baremesFrais', 'AdminController::baremesFrais');

    // Type opérateurs
    $routes->get('type-operateurs', 'AdminController::typeOperateurs');
    $routes->post('type-operateurs/save', 'AdminController::saveTypeOperateur');
    $routes->post('type-operateurs/delete/(:num)', 'AdminController::deleteTypeOperateur/$1');

    // Préfixes
    $routes->get('prefixes', 'AdminController::prefixes');
    $routes->post('prefixes/save', 'AdminController::savePrefixe');
    $routes->post('prefixes/delete/(:num)', 'AdminController::deletePrefixe/$1');

    // Type transactions
    $routes->get('type-transactions', 'AdminController::typeTransactions');
    $routes->post('type-transactions/save', 'AdminController::saveTypeTransaction');
    $routes->post('type-transactions/delete/(:num)', 'AdminController::deleteTypeTransaction/$1');

    // Relations opérateurs
    $routes->get('relation-operateurs', 'AdminController::relationsOperateurs');
    $routes->post('relation-operateurs/save', 'AdminController::saveRelationOperateur');
    $routes->post('relation-operateurs/delete/(:num)', 'AdminController::deleteRelationOperateur/$1');

    // Frais
    $routes->get('frais', 'AdminController::frais');
    $routes->post('frais/save', 'AdminController::saveFrais');
    $routes->post('frais/delete/(:num)', 'AdminController::deleteFrais/$1');
});
