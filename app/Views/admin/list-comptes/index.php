<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Liste des comptes</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f5f7fb;color:#172033;margin:0}header{background:#123a68;color:#fff;padding:18px 8%}main{max-width:1250px;margin:28px auto;padding:0 18px}section{background:#fff;padding:22px;border-radius:8px;box-shadow:0 1px 5px #d9dfeb}table{width:100%;border-collapse:collapse;margin-top:12px}th,td{padding:10px;border-bottom:1px solid #e1e6ee;text-align:left}th{background:#f5f8fc}select,button{padding:8px;border:1px solid #c5cfdb;border-radius:4px}button{background:#087b70;color:#fff;border:0;cursor:pointer}a{color:#075eaa;text-decoration:none}.success{color:#067647}.error{color:#b42318}
    </style>
</head>
<body>
<header><strong>Administration Mobile Money</strong></header>
<main>
    <p><a href="<?= site_url('admin/dashboard') ?>">← Tableau de bord</a></p>
    <h1>Situation des comptes clients</h1>
    <?php if (!empty($success)): ?><p class="success"><?= esc($success) ?></p><?php endif; ?>
    <?php foreach ($errors ?? [] as $error): ?><p class="error"><?= esc($error) ?></p><?php endforeach; ?>
    <section>
        <table>
            <thead><tr><th>Client</th><th>Numéro</th><th>Opérateur</th><th>Type de compte</th><th>Solde</th><th>Statut</th><th>Historique</th></tr></thead>
            <tbody>
            <?php if (empty($comptes)): ?><tr><td colspan="7">Aucun compte client enregistré.</td></tr><?php endif; ?>
            <?php foreach ($comptes as $compte): ?>
                <tr>
                    <td><?= esc(trim(($compte['nom'] ?? '').' '.($compte['prenom'] ?? ''))) ?></td>
                    <td><?= esc($compte['numero']) ?></td>
                    <td><?= esc($compte['operateur']) ?></td>
                    <td><?= esc($compte['typeCompte']) ?></td>
                    <td><?= number_format((float)$compte['solde'], 2, ',', ' ') ?> Ar</td>
                    <td>
                        <form method="post" action="<?= site_url('admin/listComptes/statut/'.$compte['id']) ?>">
                            <?= csrf_field() ?>
                            <select name="idStatusCompte" onchange="this.form.submit()">
                                <?php foreach ($statuts as $statut): ?>
                                    <option value="<?= esc($statut['id']) ?>" <?= (int)($compte['idStatusCompte'] ?? 0) === (int)$statut['id'] ? 'selected' : '' ?>><?= esc($statut['libelle']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td><a href="<?= site_url('admin/listComptes/'.$compte['id'].'/transactions') ?>">Voir les transactions</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
