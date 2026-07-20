<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert d'argent</title>
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
            max-width: 480px;
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

        .form-control,
        textarea.form-control {
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

        .fee-box {
            background: #f7f9fa;
            border: 1px solid #eef0f2;
            border-radius: 14px;
            padding: 14px 16px;
            margin: 18px 0;
        }

        .fee-box .fee-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--mv-text-soft);
            margin-bottom: 6px;
        }

        .fee-box .fee-row:last-child {
            margin-bottom: 0;
            font-weight: 700;
            color: #1a2530;
            font-size: 0.92rem;
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
            <div class="op-icon"><i class="fa-solid fa-paper-plane"></i></div>
            <h2>Effectuer un transfert</h2>
            <p>Envoyez de l'argent à un autre compte MVola</p>
        </div>

        <div class="op-body">
            <form id="formTransfert">
                <div class="mb-3">
                    <label for="numero" class="form-label">Numéro du destinataire</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (Ar)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-coins"></i></span>
                        <input type="number" class="form-control" id="montant" name="montant" min="1" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="raison" class="form-label">Raison</label>
                    <textarea class="form-control" id="raison" name="raison" rows="3"></textarea>
                </div>

                <div class="fee-box">
                    <div class="fee-row">
                        <span>Frais</span>
                        <span><span id="frais">0</span> Ar</span>
                    </div>
                    <div class="fee-row">
                        <span>Montant total</span>
                        <span><span id="montantFinal">0</span> Ar</span>
                    </div>
                </div>

                <div id="resultat" role="status"></div>

                <button type="submit" class="btn-mvola">
                    <i class="fa-solid fa-paper-plane me-1"></i> Transférer
                </button>
            </form>

            <a href="<?= base_url('/') ?>" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Retour au tableau de bord
            </a>
        </div>
    </div>

    <script>
        const formTransfert = document.getElementById('formTransfert');
        const resultat = document.getElementById('resultat');
        const montant = document.getElementById('montant');
        const numero = document.getElementById('numero');
        const frais = document.getElementById('frais');
        const montantFinal = document.getElementById('montantFinal');
        let attenteFrais;

        async function afficherFrais() {
            const valeur = Number(montant.value) || 0;

            if (valeur <= 0 || !numero.value.trim()) {
                frais.textContent = '0';
                montantFinal.textContent = valeur;
                return;
            }

            const donnees = new FormData();
            donnees.append('type', 'transfert');
            donnees.append('montant', valeur);
            donnees.append('numero', numero.value.trim());
            const response = await fetch("<?= base_url('frais') ?>", {
                method: 'POST',
                body: donnees
            });
            const data = await response.json();

            if (response.ok && data.status === 'success') {
                frais.textContent = data.frais;
                montantFinal.textContent = data.montantFinal;
            }
        }

        [montant, numero].forEach((champ) => champ.addEventListener('input', () => {
            clearTimeout(attenteFrais);
            attenteFrais = setTimeout(afficherFrais, 250);
        }));

        formTransfert.addEventListener('submit', async (event) => {
            event.preventDefault();
            resultat.className = '';
            resultat.textContent = 'Traitement en cours…';

            try {
                const response = await fetch("<?= base_url('transfert') ?>", {
                    method: 'POST',
                    body: new FormData(formTransfert),
                });
                const data = await response.json();

                if (!response.ok || data.status !== 'success') {
                    throw new Error(data.message || 'Le transfert a échoué.');
                }

                resultat.className = 'success';
                resultat.textContent = `${data.message}. Frais : ${data.frais} Ar. Nouveau solde : ${data.nouveauSolde} Ar`;
                formTransfert.reset();
            } catch (error) {
                resultat.className = 'error';
                resultat.textContent = error.message || 'Une erreur est survenue.';
            }
        });
    </script>

</body>

</html>