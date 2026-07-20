<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un dépôt</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --mv-navy-dark: #0b2e3d;
            --mv-teal: #14806f;
            --mv-yellow: #ffcc00;
            --mv-bg: #f2f4f6;
            --mv-text-soft: #6b7785;
        }

        body {
            background: var(--mv-bg);
            font-family: 'Segoe UI', Roboto, -apple-system, sans-serif;
            color: #1a2530;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .op-card {
            width: 100%;
            max-width: 460px;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(11, 46, 61, 0.08);
        }

        .op-header {
            background: linear-gradient(135deg, var(--mv-navy-dark) 0%, var(--mv-teal) 100%);
            color: #fff;
            padding: 26px 28px 60px;
            position: relative;
        }

        .op-header::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            top: -70px;
            right: -50px;
        }

        .op-header .op-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 12px;
        }

        .op-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .op-header p {
            font-size: 0.82rem;
            opacity: 0.85;
            margin: 4px 0 0;
        }

        .op-body {
            padding: 28px 28px 30px;
            margin-top: -34px;
            background: #fff;
            border-radius: 22px 22px 0 0;
            position: relative;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--mv-text-soft);
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #e3e7eb;
            padding: 12px 14px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--mv-teal);
            box-shadow: 0 0 0 3px rgba(20, 128, 111, 0.12);
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            background: #eef7f5;
            border: 1px solid #e3e7eb;
            border-right: none;
            color: var(--mv-teal);
        }

        .btn-mvola {
            background: var(--mv-yellow);
            color: var(--mv-navy-dark);
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 13px;
            width: 100%;
            font-size: 0.95rem;
        }

        .btn-mvola:hover {
            background: #f0b800;
            color: var(--mv-navy-dark);
        }

        #resultat {
            font-size: 0.85rem;
            min-height: 20px;
            margin-bottom: 14px;
        }

        #resultat.success {
            color: var(--mv-teal);
            font-weight: 600;
        }

        #resultat.error {
            color: #d94747;
            font-weight: 600;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--mv-text-soft);
            text-decoration: none;
            font-size: 0.85rem;
            margin-top: 18px;
        }

        .back-link:hover {
            color: var(--mv-navy-dark);
        }
    </style>
</head>

<body>

    <div class="op-card">
        <div class="op-header">
            <div class="op-icon"><i class="fa-solid fa-plus"></i></div>
            <h2>Effectuer un dépôt</h2>
            <p>Ajoutez de l'argent sur votre compte MVola</p>
        </div>

        <div class="op-body">
            <form id="formDepot">
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (Ar)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-coins"></i></span>
                        <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                    </div>
                </div>

                <div id="resultat" role="status"></div>

                <button type="submit" class="btn-mvola">
                    <i class="fa-solid fa-check me-1"></i> Effectuer
                </button>
            </form>

            <a href="<?= base_url('/') ?>" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Retour au tableau de bord
            </a>
        </div>
    </div>

    <script>
        const formDepot = document.getElementById('formDepot');
        const resultat = document.getElementById('resultat');

        formDepot.addEventListener('submit', async (event) => {
            event.preventDefault();
            resultat.className = '';
            resultat.textContent = 'Traitement en cours…';

            try {
                const response = await fetch("<?= base_url('depot') ?>", {
                    method: 'POST',
                    body: new FormData(formDepot),
                });
                const data = await response.json();

                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.message || 'Le dépôt a échoué.');
                }

                resultat.className = 'success';
                resultat.textContent = `${data.message}. Nouveau solde : ${data.nouveauSolde} Ar`;
                formDepot.reset();
            } catch (error) {
                resultat.className = 'error';
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>

</html>