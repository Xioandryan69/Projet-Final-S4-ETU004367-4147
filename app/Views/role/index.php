<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Test Validation AJAX</title>
    <script src="<?= base_url('assets/js/validation.js') ?>"></script>

    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Créer un nouveau Rôle</h2>

    <form id="roleForm">
        <label for="name">Nom du rôle :</label>
        <input type="text" id="name" name="name">
        <div id="name_error" class="error-message"></div>

        <br>
        <button type="submit">Enregistrer</button>
    </form>

    <script>
        initFormValidation(
            "<?= site_url('role/create') ?>",
            "roleForm"
        );
    </script>


</body>

</html>