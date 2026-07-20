<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --mv-navy-dark: #0b2e3d;
            --mv-teal: #14806f;
            --mv-yellow: #ffcc00;
            --mv-yellow-dark: #f0b800;
            --mv-bg: #f2f4f6;
            --mv-text-soft: #6b7785;
        }

        body {
            background: var(--mv-bg);
            font-family: 'Segoe UI', Roboto, -apple-system, sans-serif;
            color: #1a2530;
        }

        .phone-shell {
            max-width: 420px;
            margin: 0 auto;
            min-height: 100vh;
            background: #fff;
            position: relative;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.06);
            padding-bottom: 90px;
        }

        /* Top bar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 4px;
        }

        .topbar .brand {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .topbar .brand small {
            display: block;
            font-weight: 400;
            font-size: 0.7rem;
            color: var(--mv-text-soft);
        }

        .topbar .icons i {
            font-size: 1.05rem;
            margin-left: 16px;
            color: #2b3946;
        }

        .topbar .avatar-dot {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--mv-yellow);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            margin-left: 16px;
        }

        /* Balance card */
        .balance-card {
            margin: 14px 20px 0;
            border-radius: 22px;
            padding: 22px 22px 26px;
            background: linear-gradient(135deg, var(--mv-navy-dark) 0%, var(--mv-teal) 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .balance-card::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            top: -60px;
            right: -50px;
        }

        .balance-card .label-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .balance-card .label-row .badge-round {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #fff;
            color: var(--mv-teal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .balance-card .solde {
            font-size: 2.1rem;
            font-weight: 700;
            margin-top: 14px;
            letter-spacing: 0.5px;
        }

        .balance-card .solde span {
            font-size: 1.1rem;
            font-weight: 500;
            margin-left: 6px;
            opacity: 0.85;
        }

        .balance-card .fab-row {
            position: absolute;
            right: 20px;
            bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .balance-card .fab-row .fab {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            border: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Quick actions grid */
        .quick-actions {
            margin: 22px 14px 0;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 4px;
            text-align: center;
        }

        .quick-actions a {
            text-decoration: none;
            color: #2b3946;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            padding: 6px 2px;
        }

        .quick-actions .icon-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #fff8e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            color: var(--mv-navy-dark);
            border: 1px solid #f4e5ad;
        }

        /* Promo banner */
        .promo-banner {
            margin: 22px 20px 0;
            background: linear-gradient(135deg, var(--mv-yellow) 0%, var(--mv-yellow-dark) 100%);
            border-radius: 18px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #1a1a1a;
        }

        .promo-banner .promo-text {
            font-weight: 700;
            font-size: 1.05rem;
            line-height: 1.25;
            max-width: 65%;
        }

        .promo-banner i {
            font-size: 2rem;
            opacity: 0.85;
        }

        /* Secondary actions row */
        .secondary-actions {
            margin: 22px 14px 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            text-align: center;
        }

        .secondary-actions a {
            text-decoration: none;
            color: #2b3946;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            padding: 10px 4px;
            background: #fff;
            border-radius: 14px;
            border: 1px solid #eef0f2;
        }

        .secondary-actions .icon-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #eef7f5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--mv-teal);
        }

        /* Section: history / logout */
        .panel {
            margin: 24px 20px 0;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eef0f2;
            padding: 6px 4px;
        }

        .panel a.list-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 14px;
            text-decoration: none;
            color: #1a2530;
            font-size: 0.9rem;
            border-bottom: 1px solid #f2f4f6;
        }

        .panel a.list-link:last-child {
            border-bottom: none;
        }

        .panel a.list-link i.leading {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #eef7f5;
            color: var(--mv-teal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .panel a.list-link i.trailing {
            margin-left: auto;
            color: #c3cad1;
        }

        #deconnexion {
            width: calc(100% - 40px);
            margin: 20px 20px 0;
            background: #fff;
            border: 1px solid #f1b9b9;
            color: #d94747;
            font-weight: 600;
            border-radius: 14px;
            padding: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        #deconnexion:hover {
            background: #fdecec;
        }

        /* Bottom nav */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 420px;
            background: var(--mv-navy-dark);
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 12px 10px 18px;
            border-radius: 24px 24px 0 0;
        }

        .bottom-nav i {
            color: rgba(255, 255, 255, 0.55);
            font-size: 1.15rem;
        }

        .bottom-nav .nav-center {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--mv-yellow);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -30px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
        }

        .bottom-nav .nav-center i {
            color: var(--mv-navy-dark);
            font-size: 1.3rem;
        }
    </style>
</head>

<body>

    <div class="phone-shell">

        <!-- Top bar -->
        <div class="topbar">
            <div class="brand">
                Bonjour !
                <small>Koloina Yonimanitra</small>
            </div>
            <div class="icons d-flex align-items-center">
                <i class="fa-regular fa-bell"></i>
                <i class="fa-solid fa-magnifying-glass"></i>
                <span class="avatar-dot">KY</span>
            </div>
        </div>

        <!-- Balance card -->
        <div class="balance-card">
            <div class="label-row">
                <span class="badge-round"><i class="fa-solid fa-wallet"></i></span>
                Koloina Yonimanitra
            </div>
            <div class="solde">
                <?= esc($solde) ?><span>Ar</span>
            </div>
            <div class="fab-row">
                <button class="fab"><i class="fa-solid fa-rotate"></i></button>
                <button class="fab"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="quick-actions">
            <a href="<?= base_url('transfert') ?>">
                <span class="icon-circle"><i class="fa-solid fa-paper-plane"></i></span>
                Transfert d'argent
            </a>
            <a href="<?= base_url('depot') ?>">
                <span class="icon-circle"><i class="fa-solid fa-plus"></i></span>
                Faire un dépôt
            </a>
            <a href="<?= base_url('retrait') ?>">
                <span class="icon-circle"><i class="fa-solid fa-arrow-down"></i></span>
                Retrait d'argent
            </a>
            <a href="<?= base_url('transaction') ?>">
                <span class="icon-circle"><i class="fa-solid fa-clock-rotate-left"></i></span>
                Historiques
            </a>
        </div>

        <!-- Promo banner -->
        <div class="promo-banner">
            <div class="promo-text">MVola reste<br>MVola !</div>
            <i class="fa-solid fa-people-group"></i>
        </div>

        <!-- Secondary actions -->
        <div class="secondary-actions">
            <a href="#">
                <span class="icon-circle"><i class="fa-solid fa-signal"></i></span>
                Achat forfait
            </a>
            <a href="#">
                <span class="icon-circle"><i class="fa-regular fa-credit-card"></i></span>
                Carte Visa
            </a>
            <a href="#">
                <span class="icon-circle"><i class="fa-regular fa-newspaper"></i></span>
                TV &amp; Presse
            </a>
        </div>

        <!-- History panel -->
        <div class="panel">
            <a class="list-link" href="<?= base_url('transaction') ?>">
                <i class="leading fa-solid fa-clock-rotate-left"></i>
                Voir les historiques
                <i class="trailing fa-solid fa-chevron-right"></i>
            </a>
        </div>

        <!-- Logout -->
        <button type="button" id="deconnexion">
            <i class="fa-solid fa-right-from-bracket"></i>
            Déconnexion
        </button>

        <!-- Bottom nav -->
        <div class="bottom-nav">
            <i class="fa-solid fa-house" style="color:#ffcc00;"></i>
            <i class="fa-solid fa-chart-simple"></i>
            <span class="nav-center"><i class="fa-solid fa-wallet"></i></span>
            <i class="fa-regular fa-user"></i>
            <i class="fa-solid fa-ellipsis"></i>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('deconnexion').addEventListener('click', async () => {
            const response = await fetch("<?= base_url('logout') ?>", {
                method: 'POST'
            });
            const data = await response.json();

            if (response.ok && data.status === 'success') {
                window.location.href = "<?= base_url('login') ?>";
            }
        });
    </script>

</body>

</html>