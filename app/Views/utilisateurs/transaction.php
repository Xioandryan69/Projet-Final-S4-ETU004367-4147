<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions</title>
</head>

<body>
    <h1>Historique des transactions</h1>
    <p>Compte connecté : <?= esc(session()->get('numero')) ?></p>

    <?php if (empty($transactions)): ?>
        <p>Aucune transaction pour ce compte.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Sens</th>
                    <th>Montant</th>
                    <th>Frais</th>
                    <th>Montant final</th>
                    <th>Compte source</th>
                    <th>Compte destination</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <?php
                    $credit = $transaction['typeTransaction'] === 'Depot'
                        || (int) $transaction['compteDestination_id'] === $compteId;
                    ?>
                    <tr>
                        <td><?= esc($transaction['dateTransaction']) ?></td>
                        <td><?= esc($transaction['typeTransaction']) ?></td>
                        <td><?= $credit ? 'Entrée' : 'Sortie' ?></td>
                        <td><?= esc($transaction['montant']) ?> Ar</td>
                        <td><?= esc($transaction['frais']) ?> Ar</td>
                        <td><?= esc($transaction['montantFinal']) ?> Ar</td>
                        <td><?= esc($transaction['compteSource'] ?? '-') ?></td>
                        <td><?= esc($transaction['compteDestination'] ?? '-') ?></td>
                        <td><?= esc($transaction['statut'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <br>
    <a href="<?= base_url('/') ?>">Retour</a>
</body>

</html>
