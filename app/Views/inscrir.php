<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <script src="<?= base_url('assets/js/validation.js') ?>"></script>

    <style>
        .error {
            color: red;
            font-size: 14px;
        }

        input,
        select {
            display: block;
            margin-bottom: 5px;
            width: 300px;
            padding: 8px;
        }

        button {
            padding: 8px 20px;
        }
    </style>
</head>

<body>

    <h2>Ajouter un utilisateur</h2>

    <form id="userForm">

        <label>Nom d'utilisateur</label>
        <input type="text" name="username">
        <div id="username_error" class="error"></div>

        <label>Email</label>
        <input type="email" name="email">
        <div id="email_error" class="error"></div>

        <label>Mot de passe</label>
        <input type="password" name="password">
        <div id="password_error" class="error"></div>

        <label>Rôle</label>
        <select name="role_id">
            <option value="">Sélectionner</option>
            <option value="1">Admin</option>
            <option value="2">RH</option>
            <option value="3">User</option>
        </select>
        <div id="role_id_error" class="error"></div>

        <br>

        <button type="submit">Enregistrer</button>

    </form>

    <script>
        initFormValidation(
            "<?= site_url('users/validate') ?>",
            "userForm"
        );
    </script>


</body>

</html>