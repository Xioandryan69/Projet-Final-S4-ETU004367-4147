<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait</title>
</head>

<body>

    <h2>Effectuer un Retrait</h2>

    <form id="formRetrait">

        <!-- <div>
            <label for="numero">Numéro du destinataire</label><br>
            <input type="text" id="numero" name="numero" required>
        </div> -->

        <br>

        <div>
            <label for="montant">Montant (Ar)</label><br>
            <input type="number" id="montant" name="montant" min="1" required>
        </div>

        <br>

        <br>
        <div id="resultat" role="status"></div>

        <button type="submit">Effectuer</button>

    </form>
    <a href="<?= base_url('/') ?>">retours</a>

    <script>
        const formRetrait = document.getElementById('formRetrait');
        const resultat = document.getElementById('resultat');

        formRetrait.addEventListener('submit', async (event) => {
            event.preventDefault();
            resultat.textContent = 'Traitement en cours…';

            try {
                const response = await fetch("<?= base_url('retrait') ?>", {
                    method: 'POST',
                    body: new FormData(formRetrait),
                });
                const data = await response.json();

                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.message || 'Le retrait a échoué.');
                }

                resultat.textContent = `${data.message}. Nouveau solde : ${data.nouveauSolde} Ar`;
                formRetrait.reset();
            } catch (error) {
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>

</html>
