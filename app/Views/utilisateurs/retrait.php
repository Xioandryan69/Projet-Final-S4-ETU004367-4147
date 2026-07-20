<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'client', 'active' => 'retrait']) ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-1"><i class="fa-solid fa-arrow-down me-2 text-primary"></i>Effectuer un retrait</h2>
                        <p class="text-muted small mb-4">Retirez de l'argent depuis votre compte MVola</p>

                        <form id="formRetrait">
                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant (Ar)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-coins"></i></span>
                                    <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                                </div>
                            </div>

                            <div class="bg-body-tertiary border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Frais</span>
                                    <span><span id="frais">0</span> Ar</span>
                                </div>
                                <div class="d-flex justify-content-between fw-semibold">
                                    <span>Montant total</span>
                                    <span><span id="montantFinal">0</span> Ar</span>
                                </div>
                            </div>

                            <div id="resultat" class="mb-3"></div>

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
        const formRetrait = document.getElementById('formRetrait');

        const montant = document.getElementById('montant');

        const frais = document.getElementById('frais');
        const montantFinal = document.getElementById('montantFinal');

        const resultat = document.getElementById('resultat');

        let attenteFrais;



        // =============================
        // Calcul frais AJAX
        // =============================

        async function afficherFrais() {

            let valeur = Number(montant.value) || 0;
            if (valeur <= 0) {
                frais.textContent = 0;
                montantFinal.textContent = 0;
                return;
            }


            let donnees = new FormData();

            donnees.append(
                'type',
                'retrait'
            );

            donnees.append(
                'montant',
                valeur
            );


            let response = await fetch(
                "<?= base_url('frais') ?>", {
                    method: 'POST',
                    body: donnees
                }
            );


            let data = await response.json();


            if (data.status === 'success') {
                frais.textContent = data.frais;

                montantFinal.textContent =
                    data.montantFinal;
            } else {
                frais.textContent = 0;
                montantFinal.textContent = 0;
            }

        }



        montant.addEventListener(
            'input',
            () => {
                clearTimeout(attenteFrais);
                attenteFrais = setTimeout(
                    afficherFrais,
                    300
                );
            }
        );




        // =============================
        // Effectuer retrait
        // =============================

        formRetrait.addEventListener(
            'submit',
            async function(event) {

                event.preventDefault();


                resultat.className = '';
                resultat.textContent =
                    "Traitement en cours...";


                let response = await fetch(
                    "<?= base_url('retrait') ?>", {
                        method: 'POST',
                        body: new FormData(formRetrait)
                    }
                );


                let data = await response.json();



                if (data.status === 'success') {

                    resultat.className = 'text-success fw-semibold';
                    resultat.textContent =
                        data.message +
                        " Nouveau solde : " +
                        data.nouveauSolde +
                        " Ar";


                    formRetrait.reset();


                    frais.textContent = 0;
                    montantFinal.textContent = 0;

                } else {

                    resultat.className = 'text-danger fw-semibold';
                    resultat.textContent =
                        data.message;

                }


            });
    </script>


</body>
</html>
