<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Connexion</title>
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
    <!-- Réutilisation de votre script global -->
    <script src="<?= base_url('assets/js/login.js') ?>"></script>
    <script src="<?= base_url('assets/js/validation.js') ?>"></script>
</head>

<body>

    <div class="card login-card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="h5 text-center mb-4">Espace Admin - Connexion</h2>

            <div id="login_error" class="text-danger fw-bold mb-2"></div>

            <form id="adminLoginForm">
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email Administrateur" value="admin@test.com" required>
                    <div id="email_error" class="text-danger small mt-1"></div>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" value="123456789" required>
                    <div id="password_error" class="text-danger small mt-1"></div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Se connecter
                </button>
            </form>

            <p class="text-center mt-3 mb-0">
                <a href="<?= site_url('login') ?>">Se connecter en tant que client</a>
            </p>
        </div>
    </div>

    <script>
        // Validation en temps réel (Ajax) pendant la saisie
        initFormValidation("<?= site_url('admin/validateAjax') ?>", "adminLoginForm");

        // Soumission du formulaire de connexion
        document.getElementById("adminLoginForm").addEventListener("submit", function(e) {
            e.preventDefault();
            login("<?= site_url('admin/login') ?>", "adminLoginForm");
        });
    </script>

</body>

</html>