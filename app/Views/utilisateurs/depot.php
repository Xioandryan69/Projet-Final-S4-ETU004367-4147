<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un dépôt</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'client', 'active' => 'depot']) ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-1"><i class="fa-solid fa-plus me-2 text-primary"></i>Effectuer un dépôt</h2>
                        <p class="text-muted small mb-4">Ajoutez de l'argent sur votre compte MVola</p>

                        <form id="formDepot">
                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant (Ar)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-coins"></i></span>
                                    <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                                </div>
                            </div>

                            <div id="resultat" role="status" class="mb-3"></div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-check me-1"></i> Effectuer
                            </button>
                        </form>

                        <a href="<?= base_url('/') ?>" class="d-inline-block mt-3 small text-muted">
                            <i class="fa-solid fa-arrow-left me-1"></i> Retour au tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const formDepot = document.getElementById('formDepot');
        const resultat = document.getElementById('resultat');

        formDepot.addEventListener('submit', async (event) => {
            event.preventDefault();
            resultat.className = '';
            resultat.textContent = 'Traitement en cours…';

            try {
                const response = await fetch("<?= base_url('depot') ?>", {
                    method: 'POST',
                    body: new FormData(formDepot),
                });
                const data = await response.json();

                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.message || 'Le dépôt a échoué.');
                }

                resultat.className = 'text-success fw-semibold';
                resultat.textContent = `${data.message}. Nouveau solde : ${data.nouveauSolde} Ar`;
                formDepot.reset();
            } catch (error) {
                resultat.className = 'text-danger fw-semibold';
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>
</html>
