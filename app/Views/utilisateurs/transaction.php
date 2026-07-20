<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des transactions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'client', 'active' => 'transaction']) ?>

    <div class="container">
        <h2 class="h5 mb-1"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Historique des transactions</h2>
        <p class="text-muted small mb-4">Compte connecté : <?= esc(session()->get('numero')) ?></p>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <?php if (empty($transactions)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fa-regular fa-folder-open fs-2 d-block mb-2"></i>
                        Aucune transaction pour ce compte.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
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
                                    <th>Raison</th>
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
                                            <span class="badge <?= $credit ? 'text-bg-success-subtle text-success-emphasis' : 'text-bg-danger-subtle text-danger-emphasis' ?>">
                                                <i class="fa-solid <?= $credit ? 'fa-arrow-down' : 'fa-arrow-up' ?>"></i>
                                                <?= $credit ? 'Entrée' : 'Sortie' ?>
                                            </span>
                                        </td>
                                        <td><?= esc($transaction['montant']) ?> Ar</td>
                                        <td><?= esc($transaction['frais']) ?> Ar</td>
                                        <td><strong><?= esc($transaction['montantFinal']) ?> Ar</strong></td>
                                        <td><?= esc($transaction['compteSource'] ?? '-') ?></td>
                                        <td><?= esc($transaction['compteDestination'] ?? (str_contains((string) ($transaction['raison'] ?? ''), 'autre opérateur') ? 'Autre opérateur' : '-')) ?></td>
                                        <td><?= esc($transaction['raison'] ?? '-') ?></td>
                                        <td><span class="badge text-bg-warning-subtle text-warning-emphasis"><?= esc($transaction['statut'] ?? '-') ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= base_url('/') ?>" class="d-inline-block mt-3 small text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Retour au tableau de bord
        </a>
    </div>

</body>
</html>
