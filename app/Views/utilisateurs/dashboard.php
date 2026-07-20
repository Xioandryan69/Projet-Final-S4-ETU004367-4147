<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?= view('layouts/header', ['role' => 'client', 'active' => 'dashboard']) ?>

    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 text-white" style="background-color:#123a68;">
                    <div class="card-body">
                        <div class="text-white-50 mb-1"><i class="fa-solid fa-wallet me-1"></i> Solde disponible</div>
                        <div class="fs-2 fw-bold"><?= esc($solde) ?> <span class="fs-6 fw-normal">Ar</span></div>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="h6 text-uppercase text-muted mt-4 mb-3">Actions rapides</h2>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a class="btn btn-outline-primary w-100 py-3" href="<?= base_url('depot') ?>">
                    <i class="fa-solid fa-plus d-block mb-2 fs-4"></i> Dépôt
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a class="btn btn-outline-primary w-100 py-3" href="<?= base_url('retrait') ?>">
                    <i class="fa-solid fa-arrow-down d-block mb-2 fs-4"></i> Retrait
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a class="btn btn-outline-primary w-100 py-3" href="<?= base_url('transfert') ?>">
                    <i class="fa-solid fa-paper-plane d-block mb-2 fs-4"></i> Transfert
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a class="btn btn-outline-primary w-100 py-3" href="<?= base_url('transaction') ?>">
                    <i class="fa-solid fa-clock-rotate-left d-block mb-2 fs-4"></i> Historiques
                </a>
            </div>
        </div>
    </div>

</body>
</html>
