<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration — Gains des frais</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layouts/header', ['role' => 'admin', 'active' => 'baremes']) ?>

<div class="container">
    <h1 class="h4 mb-1">Situation des gains via les différents frais</h1>
    <p class="text-muted mb-4">Les gains de l’opérateur local et les commissions des autres opérateurs sont séparés.</p>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100"><div class="card-body">
                <div class="text-muted">Gains de l’opérateur local</div>
                <div class="fs-2 fw-bold text-success"><?= number_format((float) $total, 2, ',', ' ') ?> Ar</div>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100"><div class="card-body">
                <div class="text-muted">Commissions des autres opérateurs</div>
                <div class="fs-2 fw-bold text-primary"><?= number_format((float) $totalAutresOperateurs, 2, ',', ' ') ?> Ar</div>
            </div></div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h5 mb-3">Opérateur local — détail par opération</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead><tr><th>Type d’opération</th><th>Nombre d’opérations</th><th>Frais encaissés</th></tr></thead>
                    <tbody>
                    <?php if (empty($gains)): ?>
                        <tr><td colspan="3">Aucune opération de retrait ou transfert enregistrée.</td></tr>
                    <?php else: ?>
                        <?php foreach ($gains as $gain): ?>
                            <tr>
                                <td><?= esc($gain['typeTransaction']) ?></td>
                                <td><?= esc($gain['nombreOperations']) ?></td>
                                <td><?= number_format((float) $gain['totalFrais'], 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Autres opérateurs — commissions par opérateur</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead><tr><th>Opérateur</th><th>Mouvements</th><th>Montant envoyé</th><th>Commission</th></tr></thead>
                    <tbody>
                    <?php if (empty($gainsAutresOperateurs)): ?>
                        <tr><td colspan="4">Aucun mouvement vers un autre opérateur.</td></tr>
                    <?php else: ?>
                        <?php foreach ($gainsAutresOperateurs as $gain): ?>
                            <tr><td><?= esc($gain['operateur']) ?></td><td><?= esc($gain['nombreMouvements']) ?></td><td><?= number_format((float) $gain['montantTotal'], 2, ',', ' ') ?> Ar</td><td><?= number_format((float) $gain['commissionTotal'], 2, ',', ' ') ?> Ar</td></tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
