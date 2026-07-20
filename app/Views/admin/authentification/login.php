<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; width: 350px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        .error-msg { color: red; font-size: 0.9em; margin-top: 5px; }
        #login_error { color: red; font-weight: bold; margin-bottom: 10px; }
    </style>
    <!-- Réutilisation de votre script global -->
    <script src="<?= base_url('assets/js/login.js') ?>"></script>
    <script src="<?= base_url('assets/js/validation.js') ?>"></script>
</head>
<body>

    <h2>Espace Admin - Connexion</h2>

    <div id="login_error"></div>

    <form id="adminLoginForm">
        <div class="form-group">
            <input type="email" name="email" placeholder="Email Administrateur" required style="width: 100%; padding: 8px;">
            <div id="email_error" class="error-msg"></div>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Mot de passe" required style="width: 100%; padding: 8px;">
            <div id="password_error" class="error-msg"></div>
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">
            Se connecter
        </button>
    </form>

    <script>
        // Validation en temps réel (Ajax) pendant la saisie
        initFormValidation("<?= site_url('admin/validateAjax') ?>", "adminLoginForm");

        // Soumission du formulaire de connexion
        document.getElementById("adminLoginForm").addEventListener("submit", function (e) {
            e.preventDefault();
            login("<?= site_url('admin/login') ?>", "adminLoginForm");
        });
    </script>

</body>
</html>