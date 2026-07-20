<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        nav { background: #333; padding: 10px; margin-bottom: 20px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; }
        nav a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <nav>
        <a href="<?= site_url('admin/dashboard') ?>"> Dashboard</a>
        <a href="<?= site_url('admin/type-operateurs') ?>"> Types d’opérateurs</a>
        <a href="<?= site_url('admin/prefixes') ?>"> Préfixes</a>
        <a href="<?= site_url('admin/type-transactions') ?>"> Types de transactions</a>
        <a href="<?= site_url('admin/relation-operateurs') ?>"> Relations opérateurs</a>
        <a href="<?= site_url('admin/frais') ?>"> Frais</a>
        <a href="<?= site_url('admin/gains-frais') ?>"> Gains retrait / transfert</a>
        <a href="<?= site_url('admin/baremesFrais') ?>"> Barèmes Frais</a>
        <a href="<?= site_url('admin/listComptes') ?>">Liste des Comptes</a>
        <a href="<?= site_url('admin/transaction') ?>"> Transactions</a>
    </nav>

    <h2>📊 Tableau de Bord Principal</h2>
    <p>Bienvenue dans votre espace d'administration.</p>

</body>
</html>
