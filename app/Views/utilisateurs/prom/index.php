<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Promotions sur les frais de transfert</h3>
        <a href="<?= base_url('prom/create') ?>" class="btn btn-primary">Ajouter une promotion</a>
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
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotions as $promotion): ?>
                <tr>
                    <td><?= esc($promotion['id']) ?></td>
                    <td><?= esc($promotion['pourcentage']) ?> %</td>
                    <td><?= esc($promotion['dateCreation']) ?></td>
                    <td>
                        <a href="<?= base_url('prom/edit/' . $promotion['id']) ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="<?= base_url('prom/delete/' . $promotion['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Supprimer cette promotion ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($promotions)): ?>
                <tr>
                    <td colspan="4" class="text-center">Aucune promotion enregistrée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>