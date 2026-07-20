<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --mv-navy-dark: #0b2e3d;
            --mv-teal: #14806f;
            --mv-yellow: #ffcc00;
            --mv-bg: #f2f4f6;
            --mv-text-soft: #6b7785;
        }

        body {
            background: var(--mv-bg);
            font-family: 'Segoe UI', Roboto, -apple-system, sans-serif;
            color: #1a2530;
            padding: 0 0 60px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--mv-navy-dark) 0%, var(--mv-teal) 100%);
            color: #fff;
            padding: 34px 5% 70px;
            position: relative;
            overflow: hidden;
        }

        .page-header::after {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            top: -100px;
            right: 5%;
        }

        .page-header h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0 0 6px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i {
            background: rgba(255, 255, 255, 0.15);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }

        .page-header p {
            font-size: 0.85rem;
            opacity: 0.85;
            margin: 0;
        }

        .content-wrap {
            max-width: 1100px;
            margin: -40px auto 0;
            padding: 0 5%;
        }

        .table-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(11, 46, 61, 0.08);
            overflow: hidden;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: #f7f9fa;
            border-bottom: 1px solid #eef0f2;
            color: var(--mv-text-soft);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-weight: 700;
            padding: 14px 16px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px 16px;
            font-size: 0.88rem;
            vertical-align: middle;
            border-bottom: 1px solid #f2f4f6;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-sens {
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-sens.entree {
            background: #e6f4f1;
            color: var(--mv-teal);
        }

        .badge-sens.sortie {
            background: #fdecec;
            color: #d94747;
        }

        .badge-statut {
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #fff8e1;
            color: #8a6d00;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--mv-text-soft);
        }

        .empty-state i {
            font-size: 2rem;
            color: #c3cad1;
            margin-bottom: 12px;
            display: block;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--mv-text-soft);
            text-decoration: none;
            font-size: 0.85rem;
            margin-top: 22px;
        }

        .back-link:hover {
            color: var(--mv-navy-dark);
        }
    </style>
</head>

<body>

    <div class="page-header">
        <h1><i class="fa-solid fa-clock-rotate-left"></i> Historique des transactions</h1>
        <p>Compte connecté : <?= esc(session()->get('numero')) ?></p>
    </div>

    <div class="content-wrap">
        <div class="table-card">
            <?php if (empty($transactions)): ?>
                <div class="empty-state">
                    <i class="fa-regular fa-folder-open"></i>
                    Aucune transaction pour ce compte.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
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
                                    <td>
                                        <span class="badge-sens <?= $credit ? 'entree' : 'sortie' ?>">
                                            <i class="fa-solid <?= $credit ? 'fa-arrow-down' : 'fa-arrow-up' ?>"></i>
                                            <?= $credit ? 'Entrée' : 'Sortie' ?>
                                        </span>
                                    </td>
                                    <td><?= esc($transaction['montant']) ?> Ar</td>
                                    <td><?= esc($transaction['frais']) ?> Ar</td>
                                    <td><strong><?= esc($transaction['montantFinal']) ?> Ar</strong></td>
                                    <td><?= esc($transaction['compteSource'] ?? '-') ?></td>
                                    <td><?= esc($transaction['compteDestination'] ?? '-') ?></td>
                                    <td><span class="badge-statut"><?= esc($transaction['statut'] ?? '-') ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <a href="<?= base_url('/') ?>" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Retour au tableau de bord
        </a>
    </div>

</body>

</html>