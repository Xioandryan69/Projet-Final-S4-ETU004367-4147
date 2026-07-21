<div class="container mt-4">
    <h3>Modifier l'épargne</h3>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('eparne/update/' . $promotion['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="pourcentage" class="form-label">Pourcentage (%)</label>
            <input type="number" step="0.01" min="0" max="100" name="pourcentage" id="pourcentage"
                class="form-control" value="<?= old('pourcentage', $promotion['pourcentage']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="<?= base_url('eparne') ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>