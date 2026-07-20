<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateur - Connexion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #123a68;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>

    <div class="card login-card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="h5 text-center mb-4">Espace Client - Connexion</h2>

            <form id="formLogin">
                <div class="mb-3">
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Numéro de téléphone" value="0349674200" required>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" id="motDePasse" name="motDePasse" placeholder="Mot de passe" value="0349674200">
                </div>

                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <p id="resultat" class="text-danger fw-bold mb-2"></p>

            <p class="text-center mt-3 mb-0">
                <a href="<?= site_url('admin/login') ?>">Se connecter en tant qu'administrateur</a>
            </p>

            <p class="text-center mt-3 mb-0">
                autre numero :0384720934
            </p>
        </div>
    </div>

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

            const resultat = document.getElementById("resultat");
            resultat.className = '';
            resultat.textContent = 'Connexion en cours…';

            fetch("<?= base_url('login') ?>", {
                    method: "POST",
                    body: formData
                })

                .then(async response => {
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'La connexion a échoué.');
                    }

                    return data;
                })

                .then(data => {

                    resultat.textContent = data.message;

                    if (data.status === "success") {
                        resultat.className = 'success';
                        window.location.href = "<?= base_url('/') ?>";
                    }
                })

                .catch(error => {
                    resultat.textContent = error.message;
                });
        });
    </script>

</body>

</html>