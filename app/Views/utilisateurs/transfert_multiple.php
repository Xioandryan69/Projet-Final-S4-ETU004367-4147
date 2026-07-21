<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert multiple</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?= view('layouts/header', ['role' => 'client', 'active' => 'transfert_multiple']) ?>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h1 class="h5 mb-1"><i class="fa-solid fa-users me-2 text-primary"></i>Envoi multiple</h1>
                    <p class="text-muted small mb-4">Le montant total est réparti à parts égales entre les destinataires.</p>

                    <form id="formTransfertMultiple">
                        <div class="mb-3">
                            <label class="form-label">Numéros des destinataires</label>
                            <div id="listeNumeros"></div>
                            <button type="button" id="ajouterNumero" class="btn btn-outline-secondary btn-sm mt-2"><i class="fa-solid fa-plus me-1"></i>Ajouter un numéro</button>
                        </div>
                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant total à répartir (Ar)</label>
                            <input type="number" id="montant" name="montant" class="form-control" min="1" step="0.01" required>
                        </div>
                        <div class="alert alert-light border py-2 mb-3" id="repartition">Ajoutez des numéros et un montant pour voir la répartition.</div>
                        <div id="resultat" class="mb-3" role="status"></div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-paper-plane me-1"></i> Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const form = document.getElementById('formTransfertMultiple');
    const listeNumeros = document.getElementById('listeNumeros');
    const ajouterNumero = document.getElementById('ajouterNumero');
    const montant = document.getElementById('montant');
    const repartition = document.getElementById('repartition');
    const resultat = document.getElementById('resultat');

    function ajouterChampNumero(valeur = '') {
        const ligne = document.createElement('div');
        ligne.className = 'mb-2';
        ligne.innerHTML = `
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                <input type="text" class="form-control numero-destinataire" name="numeros[]" value="${valeur}" placeholder="Numéro du destinataire" required>
                <button type="button" class="btn btn-outline-danger supprimer-numero" aria-label="Supprimer"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="operateur-numero form-text"></div>`;
        listeNumeros.appendChild(ligne);

        const champ = ligne.querySelector('.numero-destinataire');
        const information = ligne.querySelector('.operateur-numero');
        let attente;
        champ.addEventListener('input', () => {
            afficherRepartition();
            clearTimeout(attente);
            attente = setTimeout(async () => {
                if (champ.value.trim().length < 3) {
                    information.textContent = '';
                    return;
                }
                const donnees = new FormData();
                donnees.append('numero', champ.value.trim());
                try {
                    const response = await fetch("<?= base_url('operateur-par-numero') ?>", { method: 'POST', body: donnees });
                    const data = await response.json();
                    information.className = response.ok && data.status === 'success' ? 'operateur-numero form-text text-success' : 'operateur-numero form-text text-danger';
                    information.textContent = response.ok && data.status === 'success' ? `Opérateur : ${data.operateur}` : (data.message || 'Opérateur introuvable.');
                } catch (error) {
                    information.className = 'operateur-numero form-text text-danger';
                    information.textContent = 'Impossible de vérifier l’opérateur.';
                }
            }, 250);
        });
        ligne.querySelector('.supprimer-numero').addEventListener('click', () => {
            if (listeNumeros.children.length > 1) {
                ligne.remove();
                afficherRepartition();
            }
        });
    }

    function afficherRepartition() {
        const liste = [...document.querySelectorAll('.numero-destinataire')].map((champ) => champ.value.trim()).filter(Boolean);
        const total = Number(montant.value) || 0;
        if (!liste.length || total <= 0) {
            repartition.textContent = 'Ajoutez des numéros et un montant pour voir la répartition.';
            return;
        }
        repartition.textContent = `${liste.length} destinataire(s) : ${Math.round((total / liste.length) * 100) / 100} Ar chacun, hors frais éventuels.`;
    }

    montant.addEventListener('input', afficherRepartition);
    ajouterNumero.addEventListener('click', () => ajouterChampNumero());
    ajouterChampNumero();

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        resultat.className = '';
        resultat.textContent = 'Transferts en cours…';
        try {
            const response = await fetch("<?= base_url('transfert-multiple') ?>", { method: 'POST', body: new FormData(form) });
            const data = await response.json();
            if (!response.ok || data.status !== 'success') throw new Error(data.message || 'Le transfert multiple a échoué.');
            resultat.className = 'text-success fw-semibold';
            resultat.textContent = `${data.message} ${data.nombreDestinataires} destinataire(s), ${data.montantParDestinataire} Ar chacun. Frais : ${data.totalFrais} Ar, commissions : ${data.totalCommissions} Ar. Total débité : ${data.totalDebite} Ar.`;
            form.reset();
            afficherRepartition();
        } catch (error) {
            resultat.className = 'text-danger fw-semibold';
            resultat.textContent = error.message;
        }
    });
</script>

</body>
</html>
