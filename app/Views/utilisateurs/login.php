<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <h1>Login</h1>

    <form id="formLogin">

        <input
            type="text"
            id="numero"
            name="numero"
            placeholder="Entrer votre numéro"
            required>

        <input
            type="password"
            id="motDePasse"
            name="motDePasse"
            placeholder="Mot de passe"
            required>

        <button type="submit">
            Valider
        </button>

    </form>

    <p id="resultat"></p>


    <script>
        document.getElementById("formLogin").addEventListener("submit", function(e) {

            e.preventDefault();

            let formData = new FormData();

            formData.append(
                "numero",
                document.getElementById("numero").value
            );

            formData.append(
                "motDePasse",
                document.getElementById("motDePasse").value
            );


            fetch("<?= base_url('login') ?>", {
                    method: "POST",
                    body: formData
                })

                .then(response => response.json())

                .then(data => {

                    document.getElementById("resultat").innerHTML = data.message;

                    if (data.status === "success") {
                        window.location.href = "<?= base_url('/') ?>";
                    }
                })

                .catch(error => {
                    console.log(error);
                });
        });
    </script>

</body>

</html>