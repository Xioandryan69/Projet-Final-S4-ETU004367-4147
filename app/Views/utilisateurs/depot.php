<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait</title>
</head>

<body>

    <h2>Effectuer un depot</h2>

    <form id="formDepot">


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
        const formDepot = document.getElementById('formDepot');
        const resultat = document.getElementById('resultat');

        formDepot.addEventListener('submit', async (event) => {
            event.preventDefault();
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

                resultat.textContent = `${data.message}. Nouveau solde : ${data.nouveauSolde} Ar`;
                formDepot.reset();
            } catch (error) {
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>

</html>
