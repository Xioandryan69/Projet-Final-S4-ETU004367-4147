<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Barèmes et gains</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f5f7fb;color:#172033;margin:0} header{background:#123a68;color:#fff;padding:18px 8%} main{max-width:1100px;margin:28px auto;padding:0 18px} section,.card{background:#fff;padding:22px;margin:20px 0;border-radius:8px;box-shadow:0 1px 5px #d9dfeb} input,select,button{padding:9px;margin:4px;border:1px solid #c5cfdb;border-radius:4px} button{background:#087b70;color:#fff;border:0;cursor:pointer}.danger{background:#b42318}table{width:100%;border-collapse:collapse;margin-top:12px}th,td{padding:10px;border-bottom:1px solid #e1e6ee;text-align:left}th{background:#f5f8fc}.amount{font-size:28px;color:#087b70;font-weight:bold}.success{color:#067647}.error{color:#b42318}a{color:#075eaa;text-decoration:none}
    </style>
</head>
<body>
<header><strong>Administration Mobile Money</strong></header>
<main>
    <p><a href="<?= site_url('admin/dashboard') ?>">← Tableau de bord</a></p>
    <h1>Barèmes de frais</h1>
    <?php if (!empty($success)): ?><p class="success"><?= esc($success) ?></p><?php endif; ?>
    <?php foreach ($errors ?? [] as $error): ?><p class="error"><?= esc($error) ?></p><?php endforeach; ?>

    <section>
        <h2><?= $current ? 'Modifier un barème' : 'Créer un barème' ?></h2>
        <form method="post" action="<?= site_url('admin/frais/save') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= esc($current['id'] ?? '') ?>">
            <select name="typeTransaction_id" required>
                <option value="">Type d’opération</option>
                <?php foreach ($typeTransactions as $type): ?>
                    <option value="<?= esc($type['id']) ?>" <?= (int)($current['typeTransaction_id'] ?? 0) === (int)$type['id'] ? 'selected' : '' ?>><?= esc($type['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="relationOperateur_id" required>
                <option value="">Relation opérateur</option>
                <?php foreach ($relations as $relation): ?>
                    <option value="<?= esc($relation['id']) ?>" <?= (int)($current['relationOperateur_id'] ?? 0) === (int)$relation['id'] ? 'selected' : '' ?>><?= esc($relation['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="montantMin" min="0" step="0.01" value="<?= esc($current['montantMin'] ?? '') ?>" placeholder="Montant minimum" required>
            <input type="number" name="montantMax" min="0" step="0.01" value="<?= esc($current['montantMax'] ?? '') ?>" placeholder="Montant maximum" required>
            <input type="number" name="montantFrais" min="0" step="0.01" value="<?= esc($current['montantFrais'] ?? '') ?>" placeholder="Frais" required>
            <button><?= $current ? 'Mettre à jour' : 'Enregistrer' ?></button>
            <?php if ($current): ?><a href="<?= site_url('admin/baremesFrais') ?>">Annuler</a><?php endif; ?>
        </form>
    </section>

    <section>
        <h2>Grilles tarifaires enregistrées</h2>
        <table><thead><tr><th>Opération</th><th>Relation</th><th>Minimum</th><th>Maximum</th><th>Frais</th><th>Actions</th></tr></thead><tbody>
        <?php if (empty($items)): ?><tr><td colspan="6">Aucun barème enregistré.</td></tr><?php endif; ?>
        <?php foreach ($items as $item): ?><tr><td><?= esc($item['typeTransaction']) ?></td><td><?= esc($item['relationOperateur']) ?></td><td><?= number_format((float)$item['montantMin'], 2, ',', ' ') ?> Ar</td><td><?= number_format((float)$item['montantMax'], 2, ',', ' ') ?> Ar</td><td><?= number_format((float)$item['montantFrais'], 2, ',', ' ') ?> Ar</td><td><a href="<?= site_url('admin/baremesFrais?edit='.$item['id']) ?>">Modifier</a> <form style="display:inline" method="post" action="<?= site_url('admin/frais/delete/'.$item['id']) ?>"><?= csrf_field() ?><button class="danger" onclick="return confirm('Supprimer ce barème ?')">Supprimer</button></form></td></tr><?php endforeach; ?>
        </tbody></table>
    </section>

    <section>
        <h2>Situation des gains : retrait et transfert</h2>
        <p>Total des frais encaissés : <span class="amount"><?= number_format((float)$totalGains, 2, ',', ' ') ?> Ar</span></p>
        <table><thead><tr><th>Opération</th><th>Nombre d’opérations</th><th>Frais encaissés</th></tr></thead><tbody>
        <?php if (empty($gains)): ?><tr><td colspan="3">Aucune opération de retrait ou transfert.</td></tr><?php endif; ?>
        <?php foreach ($gains as $gain): ?><tr><td><?= esc($gain['typeTransaction']) ?></td><td><?= esc($gain['nombreOperations']) ?></td><td><?= number_format((float)$gain['totalFrais'], 2, ',', ' ') ?> Ar</td></tr><?php endforeach; ?>
        </tbody></table>
    </section>
</main>
</body>
</html>
