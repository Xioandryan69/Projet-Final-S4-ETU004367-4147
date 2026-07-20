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
            --mv-navy-darker: #082530;
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

        /* Sidebar */
        .sidebar {
            background: var(--mv-navy-dark);
            min-height: 100vh;
            padding: 26px 18px;
            position: sticky;
            top: 0;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 40px;
            padding: 0 8px;
        }

        .sidebar .logo span.dot {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: var(--mv-yellow);
            color: var(--mv-navy-dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.65);
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 0.92rem;
            margin-bottom: 4px;
            transition: background .15s ease, color .15s ease;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
        }

        .sidebar .nav-link.active {
            background: var(--mv-yellow);
            color: var(--mv-navy-dark);
            font-weight: 600;
        }

        .sidebar hr {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 20px 0;
        }

        #deconnexion {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(217, 71, 71, 0.4);
            color: #ff8f8f;
            font-weight: 600;
            border-radius: 12px;
            padding: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        #deconnexion:hover {
            background: rgba(217, 71, 71, 0.12);
            color: #ffb3b3;
        }

        /* Topbar */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #eef0f2;
            padding: 18px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar .greeting small {
            display: block;
            color: var(--mv-text-soft);
            font-size: 0.8rem;
        }

        .topbar .greeting strong {
            font-size: 1.05rem;
        }

        .topbar .icons i {
            font-size: 1.05rem;
            color: #2b3946;
            margin-left: 22px;
            cursor: pointer;
        }

        .topbar .avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--mv-yellow);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            margin-left: 22px;
        }

        .content {
            padding: 30px 32px 50px;
        }

        /* Balance card */
        .balance-card {
            border-radius: 22px;
            padding: 30px 34px;
            background: linear-gradient(135deg, var(--mv-navy-dark) 0%, var(--mv-teal) 100%);
            color: #fff;
            position: relative;
            overflow: hidden;
            min-height: 190px;
        }

        .balance-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
            top: -80px;
            right: -60px;
        }

        .balance-card .label-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            opacity: 0.9;
        }

        .balance-card .label-row .badge-round {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #fff;
            color: var(--mv-teal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .balance-card .solde {
            font-size: 2.6rem;
            font-weight: 700;
            margin-top: 16px;
            letter-spacing: 0.5px;
        }

        .balance-card .solde span {
            font-size: 1.2rem;
            font-weight: 500;
            margin-left: 8px;
            opacity: 0.85;
        }

        .balance-card .fab-row {
            position: absolute;
            right: 28px;
            bottom: 26px;
            display: flex;
            gap: 12px;
        }

        .balance-card .fab-row .fab {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            border: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Promo banner */
        .promo-banner {
            border-radius: 22px;
            padding: 26px 30px;
            background: linear-gradient(135deg, var(--mv-yellow) 0%, var(--mv-yellow-dark) 100%);
            color: #1a1a1a;
            min-height: 190px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .promo-banner .promo-text {
            font-weight: 700;
            font-size: 1.35rem;
            line-height: 1.25;
        }

        .promo-banner i {
            font-size: 1.8rem;
            align-self: flex-end;
            opacity: 0.85;
        }

        /* Quick actions */
        .section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2b3946;
            margin: 30px 0 14px;
        }

        .action-card {
            background: #fff;
            border: 1px solid #eef0f2;
            border-radius: 16px;
            padding: 20px 16px;
            text-align: center;
            text-decoration: none;
            color: #2b3946;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            height: 100%;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(11, 46, 61, 0.08);
            color: var(--mv-teal);
        }

        .action-card .icon-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #eef7f5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--mv-teal);
        }

        .action-card.yellow .icon-circle {
            background: #fff8e1;
            color: var(--mv-navy-dark);
            border: 1px solid #f4e5ad;
        }

        /* History panel */
        .panel {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eef0f2;
            padding: 6px 8px;
        }

        .panel a.list-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 15px 12px;
            text-decoration: none;
            color: #1a2530;
            font-size: 0.92rem;
            border-bottom: 1px solid #f2f4f6;
        }

        .panel a.list-link:last-child {
            border-bottom: none;
        }

        .panel a.list-link i.leading {
            width: 36px;
            height: 36px;
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

        @media (max-width: 991px) {
            .sidebar {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-lg-2 col-xl-2 px-0 d-none d-lg-block">
                <div class="sidebar d-flex flex-column">
                    <div class="logo">
                        <span class="dot"><i class="fa-solid fa-bolt"></i></span>
                        MVola
                    </div>

                    <nav class="flex-grow-1">
                        <a class="nav-link active" href="#">
                            <i class="fa-solid fa-house"></i> Accueil
                        </a>
                        <a class="nav-link" href="<?= base_url('depot') ?>">
                            <i class="fa-solid fa-plus"></i> Faire un dépôt
                        </a>
                        <a class="nav-link" href="<?= base_url('retrait') ?>">
                            <i class="fa-solid fa-arrow-down"></i> Faire un retrait
                        </a>
                        <a class="nav-link" href="<?= base_url('transfert') ?>">
                            <i class="fa-solid fa-paper-plane"></i> Faire un transfert
                        </a>
                        <a class="nav-link" href="<?= base_url('transaction') ?>">
                            <i class="fa-solid fa-clock-rotate-left"></i> Historiques
                        </a>
                        <hr>
                        <a class="nav-link" href="#">
                            <i class="fa-regular fa-user"></i> Mon profil
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-gear"></i> Paramètres
                        </a>
                    </nav>

                    <button type="button" id="deconnexion">
                        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                    </button>
                </div>
            </div>

            <!-- Main -->
            <div class="col-lg-10 col-xl-10 px-0">

                <!-- Topbar -->
                <div class="topbar">
                    <div class="greeting">
                        <strong>Bonjour, Koloina Yonimanitra</strong>
                        <small>Ravi de vous revoir sur votre espace MVola</small>
                    </div>
                    <div class="icons d-flex align-items-center">
                        <i class="fa-regular fa-bell"></i>
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="avatar">KY</span>
                    </div>
                </div>

                <div class="content">

                    <!-- Balance + promo row -->
                    <div class="row g-4">
                        <div class="col-lg-7">
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
                        </div>
                        <div class="col-lg-5">
                            <div class="promo-banner">
                                <div class="promo-text">MVola reste<br>MVola !</div>
                                <i class="fa-solid fa-people-group"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Quick actions -->
                    <div class="section-title">Actions rapides</div>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <a class="action-card" href="<?= base_url('transfert') ?>">
                                <span class="icon-circle"><i class="fa-solid fa-paper-plane"></i></span>
                                Transfert d'argent
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a class="action-card" href="<?= base_url('depot') ?>">
                                <span class="icon-circle"><i class="fa-solid fa-plus"></i></span>
                                Faire un dépôt
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a class="action-card" href="<?= base_url('retrait') ?>">
                                <span class="icon-circle"><i class="fa-solid fa-arrow-down"></i></span>
                                Retrait d'argent
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a class="action-card" href="<?= base_url('transaction') ?>">
                                <span class="icon-circle"><i class="fa-solid fa-clock-rotate-left"></i></span>
                                Historiques
                            </a>
                        </div>
                    </div>

                    <!-- Secondary actions -->
                    <div class="section-title">Services</div>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <a class="action-card yellow" href="#">
                                <span class="icon-circle"><i class="fa-solid fa-signal"></i></span>
                                Achat forfait
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a class="action-card yellow" href="#">
                                <span class="icon-circle"><i class="fa-regular fa-credit-card"></i></span>
                                Carte Visa
                            </a>
                        </div>
                        <div class="col-6 col-md-3">
                            <a class="action-card yellow" href="#">
                                <span class="icon-circle"><i class="fa-regular fa-newspaper"></i></span>
                                TV &amp; Presse
                            </a>
                        </div>
                    </div>

                    <!-- History panel -->
                    <div class="section-title">Dernières activités</div>
                    <div class="panel">
                        <a class="list-link" href="<?= base_url('transaction') ?>">
                            <i class="leading fa-solid fa-clock-rotate-left"></i>
                            Voir toutes les transactions
                            <i class="trailing fa-solid fa-chevron-right"></i>
                        </a>
                    </div>

                    <!-- Logout (mobile fallback, sidebar hidden below lg) -->
                    <button type="button" id="deconnexion-mobile" class="d-lg-none mt-4"
                        style="width:100%;background:#fff;border:1px solid #f1b9b9;color:#d94747;font-weight:600;border-radius:12px;padding:12px;">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Déconnexion
                    </button>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        async function faireLogout() {
            const response = await fetch("<?= base_url('logout') ?>", {
                method: 'POST'
            });
            const data = await response.json();

            if (response.ok && data.status === 'success') {
                window.location.href = "<?= base_url('login') ?>";
            }
        }

        document.getElementById('deconnexion').addEventListener('click', faireLogout);
        const btnMobile = document.getElementById('deconnexion-mobile');
        if (btnMobile) btnMobile.addEventListener('click', faireLogout);
    </script>

</body>

</html>