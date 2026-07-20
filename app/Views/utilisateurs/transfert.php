<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert d'argent</title>
</head>
<body>

    <h2>Effectuer un transfert</h2>

    <form action="traitement.php" method="post">

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

        <div>
            <label for="raison">Raison</label><br>
            <textarea id="raison" name="raison" rows="4" cols="40"></textarea>
        </div>

        <br>
         <div> frais eto ajax</div>

        <button type="submit">Transférer</button>

    </form>

</body>
</html>