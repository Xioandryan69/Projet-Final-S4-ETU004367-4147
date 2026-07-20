<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Barèmes et gains</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layouts/header', ['role' => 'admin', 'active' => 'baremes']) ?>

<div class="container">
    <h1 class="h4 mb-3">Barèmes de frais</h1>

    <?php if (!empty($success)): ?><div class="alert alert-success py-2"><?= esc($success) ?></div><?php endif; ?>
    <?php foreach ($errors ?? [] as $error): ?><div class="alert alert-danger py-2"><?= esc($error) ?></div><?php endforeach; ?>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3"><?= $current ? 'Modifier un barème' : 'Créer un barème' ?></h2>
            <form method="post" action="<?= site_url('admin/frais/save') ?>" class="row g-3">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc($current['id'] ?? '') ?>">
                <div class="col-md-6">
                    <select name="typeTransaction_id" class="form-select" required>
                        <option value="">Type d’opération</option>
                        <?php foreach ($typeTransactions as $type): ?>
                            <option value="<?= esc($type['id']) ?>" <?= (int)($current['typeTransaction_id'] ?? 0) === (int)$type['id'] ? 'selected' : '' ?>><?= esc($type['libelle']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="relationOperateur_id" class="form-select" required>
                        <option value="">Relation opérateur</option>
                        <?php foreach ($relations as $relation): ?>
                            <option value="<?= esc($relation['id']) ?>" <?= (int)($current['relationOperateur_id'] ?? 0) === (int)$relation['id'] ? 'selected' : '' ?>><?= esc($relation['libelle']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="montantMin" min="0" step="0.01" class="form-control" value="<?= esc($current['montantMin'] ?? '') ?>" placeholder="Montant minimum" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="montantMax" min="0" step="0.01" class="form-control" value="<?= esc($current['montantMax'] ?? '') ?>" placeholder="Montant maximum" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="montantFrais" min="0" step="0.01" class="form-control" value="<?= esc($current['montantFrais'] ?? '') ?>" placeholder="Frais" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary"><?= $current ? 'Mettre à jour' : 'Enregistrer' ?></button>
                    <?php if ($current): ?><a class="btn btn-secondary" href="<?= site_url('admin/baremesFrais') ?>">Annuler</a><?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Grilles tarifaires enregistrées</h2>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead><tr><th>Opération</th><th>Relation</th><th>Minimum</th><th>Maximum</th><th>Frais</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php if (empty($items)): ?><tr><td colspan="6">Aucun barème enregistré.</td></tr><?php endif; ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['typeTransaction']) ?></td>
                            <td><?= esc($item['relationOperateur']) ?></td>
                            <td><?= number_format((float)$item['montantMin'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float)$item['montantMax'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float)$item['montantFrais'], 2, ',', ' ') ?> Ar</td>
                            <td class="d-flex gap-2">
                                <a class="btn btn-sm btn-dark" href="<?= site_url('admin/baremesFrais?edit='.$item['id']) ?>">Modifier</a>
                                <form method="post" action="<?= site_url('admin/frais/delete/'.$item['id']) ?>">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce barème ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h5 mb-1">Situation des gains : retrait et transfert</h2>
            <p class="mb-3">Total des frais encaissés : <span class="fw-bold text-success fs-4"><?= number_format((float)$totalGains, 2, ',', ' ') ?> Ar</span></p>
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead><tr><th>Opération</th><th>Nombre d’opérations</th><th>Frais encaissés</th></tr></thead>
                    <tbody>
                    <?php if (empty($gains)): ?><tr><td colspan="3">Aucune opération de retrait ou transfert.</td></tr><?php endif; ?>
                    <?php foreach ($gains as $gain): ?>
                        <tr><td><?= esc($gain['typeTransaction']) ?></td><td><?= esc($gain['nombreOperations']) ?></td><td><?= number_format((float)$gain['totalFrais'], 2, ',', ' ') ?> Ar</td></tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
