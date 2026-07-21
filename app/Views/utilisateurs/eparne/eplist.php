<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Épargne</h3>
        <div>
            <a href="<?= base_url('eparne/mouvements') ?>" class="btn btn-outline-primary">Mes mouvements</a>
            <a href="<?= base_url('eparne/create') ?>" class="btn btn-primary">Ajouter une épargne</a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pourcentage (%)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotions as $promotion): ?>
                <tr>
                    <td><?= esc($promotion['id']) ?></td>
                    <td><?= esc($promotion['pourcentage']) ?> %</td>
                    <td>

                        <a href="<?= base_url('eparne/edit/' . $promotion['id']) ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="<?= base_url('eparne/delete/' . $promotion['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Supprimer cette épargne ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($promotions)): ?>
                <tr>
                    <td colspan="3" class="text-center">Aucune épargne enregistrée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="<?= base_url('eparne/mouvements') ?>" class="btn btn-sm btn-info">Voir mouvements</a>
</div>