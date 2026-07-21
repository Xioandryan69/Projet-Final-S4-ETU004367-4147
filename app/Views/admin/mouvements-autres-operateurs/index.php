<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Mouvements autres opérateurs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layouts/header', ['role' => 'admin', 'active' => 'mouvements']) ?>

<main class="container">
    <h1 class="h4 mb-1">Mouvements vers les autres opérateurs</h1>
    <p class="text-muted mb-4">Les mouvements sont séparés selon l’opérateur destinataire.</p>

    <?php if (empty($mouvements)): ?>
        <div class="alert alert-info">Aucun mouvement vers un autre opérateur.</div>
    <?php else: ?>
        <?php $parOperateur = []; foreach ($mouvements as $mouvement) { $parOperateur[$mouvement['typeOperateur']][] = $mouvement; } ?>
        <?php foreach ($parOperateur as $operateur => $items): ?>
            <?php
                $totalMontant = array_sum(array_column($items, 'montantTotal'));
                $totalCommission = array_sum(array_column($items, 'commission'));
            ?>
            <section class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 mb-0"><?= esc($operateur) ?></h2>
                        <span class="text-muted small"><?= count($items) ?> numéro(s)</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead><tr><th>Numéro</th><th>Montant envoyé</th><th>Commission</th><th>Statut</th><th>Date</th></tr></thead>
                            <tbody>
                            <?php foreach ($items as $mouvement): ?>
                                <tr>
                                    <td><?= esc($mouvement['numero']) ?></td>
                                    <td><?= number_format((float) $mouvement['montantTotal'], 2, ',', ' ') ?> Ar</td>
                                    <td><?= number_format((float) $mouvement['commission'], 2, ',', ' ') ?> Ar</td>
                                    <td><?= esc($mouvement['status']) ?></td>
                                    <td><?= esc($mouvement['dateCreation']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light fw-semibold">
                                <tr>
                                    <td>Total <?= esc($operateur) ?></td>
                                    <td><?= number_format((float) $totalMontant, 2, ',', ' ') ?> Ar</td>
                                    <td><?= number_format((float) $totalCommission, 2, ',', ' ') ?> Ar</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

</body>
</html>
