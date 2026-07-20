<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Historique client</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layouts/header', ['role' => 'admin', 'active' => 'comptes']) ?>

<div class="container">
    <p><a href="<?= site_url('admin/listComptes') ?>">← Liste des comptes</a></p>
    <h1 class="h4 mb-3">Historique des transactions</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p>
                <strong>Client :</strong> <?= esc(trim(($compte['nom'] ?? '').' '.($compte['prenom'] ?? ''))) ?><br>
                <strong>Numéro :</strong> <?= esc($compte['numero']) ?> &nbsp;|&nbsp;
                <strong>Solde :</strong> <?= number_format((float)$compte['solde'], 2, ',', ' ') ?> Ar
            </p>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead><tr><th>Date</th><th>Opération</th><th>Compte source</th><th>Compte bénéficiaire</th><th>Montant</th><th>Frais</th><th>Total</th><th>Statut</th></tr></thead>
                    <tbody>
                    <?php if (empty($transactions)): ?><tr><td colspan="8">Aucune transaction pour ce client.</td></tr><?php endif; ?>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= esc($transaction['dateTransaction']) ?></td>
                            <td><?= esc($transaction['typeTransaction']) ?></td>
                            <td><?= esc($transaction['compteSource'] ?? '—') ?></td>
                            <td><?= esc($transaction['compteDestination'] ?? '—') ?></td>
                            <td><?= number_format((float)$transaction['montant'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float)$transaction['frais'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float)$transaction['montantFinal'], 2, ',', ' ') ?> Ar</td>
                            <td><?= esc($transaction['statut'] ?? '—') ?></td>
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
