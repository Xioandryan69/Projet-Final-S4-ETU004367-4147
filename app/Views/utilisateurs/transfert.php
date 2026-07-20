<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert d'argent</title>
</head>

<body>

    <h2>Effectuer un transfert</h2>

    <form id="formTransfert">

        <div>
            <label for="numero">Numéro du destinataire</label><br>
            <input type="text" id="numero" name="numero" required>
        </div>

        <br>

        <div>
            <label for="montant">Montant (Ar)</label><br>
            <input type="number" id="montant" name="montant" min="1" required>
        </div>

        <br>

        <div>
            <label for="raison">Raison</label><br>
            <textarea id="raison" name="raison" rows="4" cols="40"></textarea>
        </div>

        <br>
        <p>Frais : <span id="frais">0</span> Ar</p>
        <p>Montant total : <span id="montantFinal">0</span> Ar</p>
        <div id="resultat" role="status"></div>

        <button type="submit">Transférer</button>

    </form>
    <a href="<?= base_url('/') ?>">retours</a>

    <script>
        const formTransfert = document.getElementById('formTransfert');
        const resultat = document.getElementById('resultat');
        const montant = document.getElementById('montant');
        const numero = document.getElementById('numero');
        const frais = document.getElementById('frais');
        const montantFinal = document.getElementById('montantFinal');
        let attenteFrais;

        async function afficherFrais() {
            const valeur = Number(montant.value) || 0;

            if (valeur <= 0 || !numero.value.trim()) {
                frais.textContent = '0';
                montantFinal.textContent = valeur;
                return;
            }

            const donnees = new FormData();
            donnees.append('type', 'transfert');
            donnees.append('montant', valeur);
            donnees.append('numero', numero.value.trim());
            const response = await fetch("<?= base_url('frais') ?>", { method: 'POST', body: donnees });
            const data = await response.json();

            if (response.ok && data.status === 'success') {
                frais.textContent = data.frais;
                montantFinal.textContent = data.montantFinal;
            }
        }

        [montant, numero].forEach((champ) => champ.addEventListener('input', () => {
            clearTimeout(attenteFrais);
            attenteFrais = setTimeout(afficherFrais, 250);
        }));

        formTransfert.addEventListener('submit', async (event) => {
            event.preventDefault();
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

                resultat.textContent = `${data.message}. Frais : ${data.frais} Ar. Nouveau solde : ${data.nouveauSolde} Ar`;
                formTransfert.reset();
            } catch (error) {
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>

</html>
