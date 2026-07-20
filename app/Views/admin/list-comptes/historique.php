<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Historique client</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f5f7fb;color:#172033;margin:0}header{background:#123a68;color:#fff;padding:18px 8%}main{max-width:1100px;margin:28px auto;padding:0 18px}section{background:#fff;padding:22px;border-radius:8px;box-shadow:0 1px 5px #d9dfeb}table{width:100%;border-collapse:collapse;margin-top:12px}th,td{padding:10px;border-bottom:1px solid #e1e6ee;text-align:left}th{background:#f5f8fc}a{color:#075eaa;text-decoration:none}
    </style>
</head>
<body>
<header><strong>Administration Mobile Money</strong></header>
<main>
    <p><a href="<?= site_url('admin/listComptes') ?>">← Liste des comptes</a></p>
    <h1>Historique des transactions</h1>
    <section>
        <p><strong>Client :</strong> <?= esc(trim(($compte['nom'] ?? '').' '.($compte['prenom'] ?? ''))) ?><br>
        <strong>Numéro :</strong> <?= esc($compte['numero']) ?> &nbsp; | &nbsp;
        <strong>Solde :</strong> <?= number_format((float)$compte['solde'], 2, ',', ' ') ?> Ar</p>
        <table>
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
    </section>
</main>
</body>
</html>
