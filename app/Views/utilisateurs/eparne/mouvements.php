<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Mouvements d'épargne</h3>
        <a href="<?= base_url('eparne') ?>" class="btn btn-secondary">Retour</a>
    </div>

    <div class="alert alert-info">
        <strong>Solde épargne actuel :</strong> <?= number_format($soldeEpargne, 2) ?> Ar
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Montant</th>
                <th>Raison</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mouvements as $mouvement): ?>
                <tr>
                    <td><?= esc($mouvement['id']) ?></td>
                    <td><?= number_format((float) $mouvement['montant'], 2) ?> Ar</td>
                    <td><?= esc($mouvement['raison']) ?></td>
                    <td><?= esc($mouvement['dateCreation']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($mouvements)): ?>
                <tr>
                    <td colspan="4" class="text-center">Aucun mouvement d'épargne enregistré.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>