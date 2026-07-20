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
    <h1 class="h4 mb-1">Situation des gains par frais</h1>
    <p class="text-muted mb-4">Ce rapport comptabilise uniquement les frais issus des retraits et des transferts.</p>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="text-muted">Total des frais encaissés</div>
            <div class="fs-2 fw-bold text-success"><?= number_format((float) $total, 2, ',', ' ') ?> Ar</div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h5 mb-3">Détail par opération</h2>
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
</div>

</body>
</html>
