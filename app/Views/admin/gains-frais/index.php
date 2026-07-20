<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration — Gains des frais</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7fb; color: #172033; margin: 0; }
        header { background: #123a68; color: white; padding: 18px 8%; }
        main { max-width: 950px; margin: 28px auto; padding: 0 18px; }
        a { color: #075eaa; text-decoration: none; }
        .card, section { background: white; padding: 22px; border-radius: 8px; box-shadow: 0 1px 5px #d9dfeb; margin-bottom: 20px; }
        .amount { color: #087b70; font-size: 30px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #e1e6ee; padding: 12px; text-align: left; }
        th { background: #f5f8fc; }
    </style>
</head>
<body>
<header><strong>Administration Mobile Money</strong></header>
<main>
    <p><a href="<?= site_url('admin/dashboard') ?>">← Tableau de bord</a></p>
    <h1>Situation des gains par frais</h1>
    <p>Ce rapport comptabilise uniquement les frais issus des retraits et des transferts.</p>

    <div class="card">
        <div>Total des frais encaissés</div>
        <div class="amount"><?= number_format((float) $total, 2, ',', ' ') ?> Ar</div>
    </div>

    <section>
        <h2>Détail par opération</h2>
        <table>
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
    </section>
</main>
</body>
</html>
