<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Préfixes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f7fb; }
        nav, .card { background: #fff; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,.08); }
        nav { padding: 12px 16px; margin-bottom: 20px; }
        nav a { margin-right: 12px; text-decoration: none; color: #1f2937; font-weight: 600; }
        .grid { display: grid; grid-template-columns: 1fr 1.3fr; gap: 20px; }
        .card { padding: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .msg { padding: 10px 12px; border-radius: 8px; margin-bottom: 12px; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 8px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; margin-bottom: 12px; }
        button, .btn { padding: 10px 12px; border: 0; border-radius: 8px; background: #111827; color: white; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-secondary { background: #6b7280; }
        .btn-danger { background: #b91c1c; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
        <a href="<?= site_url('admin/type-operateurs') ?>">Types d’opérateurs</a>
        <a href="<?= site_url('admin/prefixes') ?>">Préfixes</a>
        <a href="<?= site_url('admin/type-transactions') ?>">Types de transactions</a>
        <a href="<?= site_url('admin/relation-operateurs') ?>">Relations opérateurs</a>
        <a href="<?= site_url('admin/frais') ?>">Frais</a>
    </nav>

    <div class="grid">
        <section class="card">
            <h2><?= $current ? 'Modifier' : 'Créer' ?> un préfixe</h2>

            <?php if (! empty($success)): ?>
                <div class="msg success"><?= esc($success) ?></div>
            <?php endif; ?>

            <?php if (! empty($errors)): ?>
                <div class="msg error">
                    <?php foreach ($errors as $error): ?>
                        <div><?= esc($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('admin/prefixes/save') ?>">
                <input type="hidden" name="id" value="<?= esc($current['id'] ?? '') ?>">
                <label for="prefixe">Préfixe</label>
                <input id="prefixe" name="prefixe" value="<?= esc($current['prefixe'] ?? old('prefixe') ?? '') ?>" placeholder="033" required>
                <label for="typeOperateur_id">Type opérateur</label>
                <select id="typeOperateur_id" name="typeOperateur_id" required>
                    <option value="">Choisir</option>
                    <?php foreach ($typeOperateurs as $typeOperateur): ?>
                        <option value="<?= esc($typeOperateur['id']) ?>" <?= ((string) ($current['typeOperateur_id'] ?? old('typeOperateur_id')) === (string) $typeOperateur['id']) ? 'selected' : '' ?>>
                            <?= esc($typeOperateur['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit"><?= $current ? 'Mettre à jour' : 'Enregistrer' ?></button>
                <?php if ($current): ?>
                    <a class="btn btn-secondary" href="<?= site_url('admin/prefixes') ?>">Annuler</a>
                <?php endif; ?>
            </form>
        </section>

        <section class="card">
            <h2>Liste</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Préfixe</th>
                        <th>Opérateur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= esc($item['id']) ?></td>
                            <td><?= esc($item['prefixe']) ?></td>
                            <td><?= esc($item['typeOperateur'] ?? '') ?></td>
                            <td class="actions">
                                <a class="btn" href="<?= site_url('admin/prefixes?edit=' . $item['id']) ?>">Modifier</a>
                                <form method="post" action="<?= site_url('admin/prefixes/delete/' . $item['id']) ?>" onsubmit="return confirm('Supprimer ce préfixe ?');">
                                    <button class="btn btn-danger" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
