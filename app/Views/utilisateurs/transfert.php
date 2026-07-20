<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert d'argent</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'client', 'active' => 'transfert']) ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-1"><i class="fa-solid fa-paper-plane me-2 text-primary"></i>Effectuer un transfert</h2>
                        <p class="text-muted small mb-4">Envoyez de l'argent à un autre compte MVola</p>

                        <form id="formTransfert">
                            <input type="hidden" id="autreOperateur" name="autreOperateur" value="0">
                            <input type="hidden" id="inclureFraisRetrait" name="inclureFraisRetrait" value="0">
                            <div class="mb-3">
                                <button type="button" id="btnAutreOperateur" class="btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-arrow-right-arrow-left me-1"></i> Vers un autre opérateur
                                </button>
                                <div id="aideAutreOperateur" class="form-text d-none">Le destinataire n’a pas besoin d’avoir un compte dans cette application.</div>
                                <button type="button" id="btnFraisRetrait" class="btn btn-outline-secondary btn-sm mt-2 d-none">
                                    Inclure les frais de retrait au montant envoyé
                                </button>
                            </div>
                            <div class="mb-3">
                                <label for="numero" class="form-label">Numéro du destinataire</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control" id="numero" name="numero" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant (Ar)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-coins"></i></span>
                                    <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="raison" class="form-label">Raison</label>
                                <textarea class="form-control" id="raison" name="raison" rows="3"></textarea>
                            </div>

                            <div class="bg-body-tertiary border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Frais</span>
                                    <span><span id="frais">0</span> Ar</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Commission autre opérateur</span>
                                    <span><span id="commission">0</span> Ar</span>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>Frais de retrait inclus</span>
                                    <span><span id="fraisRetrait">0</span> Ar</span>
                                </div>
                                <div class="d-flex justify-content-between fw-semibold">
                                    <span>Montant total</span>
                                    <span><span id="montantFinal">0</span> Ar</span>
                                </div>
                            </div>

                            <div id="resultat" role="status" class="mb-3"></div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-paper-plane me-1"></i> Transférer
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
        const formTransfert = document.getElementById('formTransfert');
        const resultat = document.getElementById('resultat');
        const montant = document.getElementById('montant');
        const numero = document.getElementById('numero');
        const frais = document.getElementById('frais');
        const commission = document.getElementById('commission');
        const fraisRetrait = document.getElementById('fraisRetrait');
        const montantFinal = document.getElementById('montantFinal');
        const btnAutreOperateur = document.getElementById('btnAutreOperateur');
        const autreOperateur = document.getElementById('autreOperateur');
        const aideAutreOperateur = document.getElementById('aideAutreOperateur');
        const btnFraisRetrait = document.getElementById('btnFraisRetrait');
        const inclureFraisRetrait = document.getElementById('inclureFraisRetrait');
        let attenteFrais;

        btnAutreOperateur.addEventListener('click', () => {
            const actif = autreOperateur.value !== '1';
            autreOperateur.value = actif ? '1' : '0';
            btnAutreOperateur.classList.toggle('btn-primary', actif);
            btnAutreOperateur.classList.toggle('btn-outline-primary', !actif);
            btnAutreOperateur.innerHTML = actif
                ? '<i class="fa-solid fa-check me-1"></i> Transfert vers autre opérateur'
                : '<i class="fa-solid fa-arrow-right-arrow-left me-1"></i> Vers un autre opérateur';
            aideAutreOperateur.classList.toggle('d-none', !actif);
            btnFraisRetrait.classList.toggle('d-none', !actif);
            if (!actif) {
                inclureFraisRetrait.value = '0';
                btnFraisRetrait.classList.replace('btn-secondary', 'btn-outline-secondary');
                btnFraisRetrait.textContent = 'Inclure les frais de retrait au montant envoyé';
            }
            afficherFrais();
        });

        btnFraisRetrait.addEventListener('click', () => {
            const actif = inclureFraisRetrait.value !== '1';
            inclureFraisRetrait.value = actif ? '1' : '0';
            btnFraisRetrait.classList.toggle('btn-secondary', actif);
            btnFraisRetrait.classList.toggle('btn-outline-secondary', !actif);
            btnFraisRetrait.textContent = actif ? 'Frais de retrait inclus au montant envoyé' : 'Inclure les frais de retrait au montant envoyé';
            afficherFrais();
        });

        async function afficherFrais() {
            const valeur = Number(montant.value) || 0;

            if (valeur <= 0 || !numero.value.trim()) {
                frais.textContent = '0';
                commission.textContent = '0';
                fraisRetrait.textContent = '0';
                montantFinal.textContent = valeur;
                return;
            }

            const donnees = new FormData();
            donnees.append('type', 'transfert');
            donnees.append('montant', valeur);
            donnees.append('numero', numero.value.trim());
            donnees.append('autreOperateur', autreOperateur.value);
            donnees.append('inclureFraisRetrait', inclureFraisRetrait.value);
            const response = await fetch("<?= base_url('frais') ?>", {
                method: 'POST',
                body: donnees
            });
            const data = await response.json();

            if (response.ok && data.status === 'success') {
                frais.textContent = data.frais;
                commission.textContent = data.commission || 0;
                fraisRetrait.textContent = data.fraisRetrait || 0;
                montantFinal.textContent = data.montantFinal;
            }
        }

        [montant, numero].forEach((champ) => champ.addEventListener('input', () => {
            clearTimeout(attenteFrais);
            attenteFrais = setTimeout(afficherFrais, 250);
        }));

        formTransfert.addEventListener('submit', async (event) => {
            event.preventDefault();
            resultat.className = '';
            resultat.textContent = 'Traitement en cours…';

            try {
                const response = await fetch("<?= base_url('transfert') ?>", {
                    method: 'POST',
                    body: new FormData(formTransfert),
                });
                const data = await response.json();

                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.message || 'Le transfert a échoué.');
                }

                resultat.className = 'text-success fw-semibold';
                resultat.textContent = `${data.message}. Frais : ${data.frais} Ar. Commission : ${data.commission || 0} Ar. Frais de retrait : ${data.fraisRetrait || 0} Ar. Nouveau solde : ${data.nouveauSolde} Ar`;
                formTransfert.reset();
            } catch (error) {
                resultat.className = 'text-danger fw-semibold';
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>
</html>
