<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Dashboard</h1>
    <p>solde : <?= esc($solde) ?> Ar</p>
    <a href="<?= base_url('depot') ?>">Faire depot</a>
    <a href="<?= base_url('retrait') ?>">Faire un retrait</a>
    <a href="<?= base_url('transfert') ?>"> faire un transfert</a>
    <a href="<?= base_url('transaction') ?>">voir les historiques</a>
    <button type="button" id="deconnexion">Déconnexion</button>

    <script>
        document.getElementById('deconnexion').addEventListener('click', async () => {
            const response = await fetch("<?= base_url('logout') ?>", { method: 'POST' });
            const data = await response.json();

            if (response.ok && data.status === 'success') {
                window.location.href = "<?= base_url('login') ?>";
            }
        });
    </script>
</body>

</html>
