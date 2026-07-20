<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait</title>
</head>

<body>

    <h2>Effectuer un Retrait</h2>

    <form action="" method="post">

        <div>
            <label for="numero">Numéro du destinataire</label><br>
            <input type="text" id="numero" name="numero" required>
        </div>

        <br>

        <div>
            <label for="montant">Montant (Ar)</label><br>
            <input type="number" id="montant" name="montant" min="1" required>
        </div>

        <br>

        <br>
        <div> frais eto ajax</div>

        <button type="submit">Effectuer</button>

    </form>
    <a href="<?= base_url('/') ?>">retours</a>

</body>

</html>