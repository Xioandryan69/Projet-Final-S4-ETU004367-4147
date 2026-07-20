<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Liste des comptes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layouts/header', ['role' => 'admin', 'active' => 'comptes']) ?>

<div class="container">
    <h1 class="h4 mb-3">Situation des comptes clients</h1>
    <?php if (!empty($success)): ?><div class="alert alert-success py-2"><?= esc($success) ?></div><?php endif; ?>
    <?php foreach ($errors ?? [] as $error): ?><div class="alert alert-danger py-2"><?= esc($error) ?></div><?php endforeach; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead><tr><th>Client</th><th>Numéro</th><th>Opérateur</th><th>Type de compte</th><th>Solde</th><th>Statut</th><th>Historique</th></tr></thead>
                    <tbody>
                    <?php if (empty($comptes)): ?><tr><td colspan="7">Aucun compte client enregistré.</td></tr><?php endif; ?>
                    <?php foreach ($comptes as $compte): ?>
                        <tr>
                            <td><?= esc(trim(($compte['nom'] ?? '').' '.($compte['prenom'] ?? ''))) ?></td>
                            <td><?= esc($compte['numero']) ?></td>
                            <td><?= esc($compte['operateur']) ?></td>
                            <td><?= esc($compte['typeCompte']) ?></td>
                            <td><?= number_format((float)$compte['solde'], 2, ',', ' ') ?> Ar</td>
                            <td>
                                <form method="post" action="<?= site_url('admin/listComptes/statut/'.$compte['id']) ?>" class="mb-0">
                                    <?= csrf_field() ?>
                                    <select name="idStatusCompte" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <?php foreach ($statuts as $statut): ?>
                                            <option value="<?= esc($statut['id']) ?>" <?= (int)($compte['idStatusCompte'] ?? 0) === (int)$statut['id'] ? 'selected' : '' ?>><?= esc($statut['libelle']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                            <td><a class="btn btn-sm btn-dark" href="<?= site_url('admin/listComptes/'.$compte['id'].'/transactions') ?>">Voir les transactions</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
