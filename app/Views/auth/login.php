<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            width: 300px;
            margin: 50px auto;
        }

        #login_error {
            color: red;
            margin-bottom: 10px;
        }
    </style>

    <script src="<?= base_url('assets/js/login.js') ?>"></script>
</head>

<body>

    <h2>Connexion</h2>

    <form id="loginForm">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Mot de passe" required>

        <div id="login_error"></div>

        <button type="submit">
            Se connecter
        </button>

    </form>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function (e) {
            e.preventDefault();

            login(
                "<?= site_url('users/login') ?>",
                "loginForm"
            );
        });
    </script>

</body>

</html>