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

        <div>
            <label for="montant">Montant (Ar)</label><br>
            <input
                type="number"
                id="montant"
                name="montant"
                min="1"
                required>
        </div>

        <br>

        <p>
            Frais :
            <span id="frais">0</span> Ar
        </p>

        <p>
            Montant total :
            <span id="montantFinal">0</span> Ar
        </p>


        <div id="resultat"></div>

        <br>

        <button type="submit">
            Effectuer
        </button>

    </form>


    <a href="<?= base_url('/') ?>">
        Retour
    </a>


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

                    resultat.textContent =
                        data.message +
                        " Nouveau solde : " +
                        data.nouveauSolde +
                        " Ar";


                    formRetrait.reset();


                    frais.textContent = 0;
                    montantFinal.textContent = 0;

                } else {

                    resultat.textContent =
                        data.message;

                }


            });
    </script>


</body>

</html>