<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'admin', 'active' => 'dashboard']) ?>

    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h2 class="h4 mb-2">📊 Tableau de Bord Principal</h2>
                <p class="text-muted mb-0">Bienvenue dans votre espace d'administration.</p>
            </div>
        </div>
    </div>

</body>
</html>
