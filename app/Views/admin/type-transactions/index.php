<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Types de transactions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'admin', 'active' => 'types']) ?>

    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="h5 mb-3"><?= $current ? 'Modifier' : 'Créer' ?> un type de transaction</h2>

                        <?php if (! empty($success)): ?>
                            <div class="alert alert-success py-2"><?= esc($success) ?></div>
                        <?php endif; ?>

                        <?php if (! empty($errors)): ?>
                            <div class="alert alert-danger py-2">
                                <?php foreach ($errors as $error): ?>
                                    <div><?= esc($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="<?= site_url('admin/type-transactions/save') ?>">
                            <input type="hidden" name="id" value="<?= esc($current['id'] ?? '') ?>">
                            <div class="mb-3">
                                <label for="libelle" class="form-label">Libellé</label>
                                <input id="libelle" name="libelle" class="form-control" value="<?= esc($current['libelle'] ?? old('libelle') ?? '') ?>" placeholder="Retrait" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><?= $current ? 'Mettre à jour' : 'Enregistrer' ?></button>
                            <?php if ($current): ?>
                                <a class="btn btn-secondary" href="<?= site_url('admin/type-transactions') ?>">Annuler</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="h5 mb-3">Liste</h2>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Libellé</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr>
                                            <td><?= esc($item['id']) ?></td>
                                            <td><?= esc($item['libelle']) ?></td>
                                            <td class="d-flex gap-2">
                                                <a class="btn btn-sm btn-dark" href="<?= site_url('admin/type-transactions?edit=' . $item['id']) ?>">Modifier</a>
                                                <form method="post" action="<?= site_url('admin/type-transactions/delete/' . $item['id']) ?>" onsubmit="return confirm('Supprimer ce type ?');">
                                                    <button class="btn btn-sm btn-danger" type="submit">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
