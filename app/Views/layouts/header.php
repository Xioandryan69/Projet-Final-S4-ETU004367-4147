<?php

/**
 * Header de navigation partagé — même design pour l'espace client et l'espace admin.
 *
 * Variables attendues :
 * - $role   : 'admin' ou 'client' (défaut : 'client')
 * - $active : clé du lien actif (optionnel)
 */
$role   = $role ?? 'client';
$active = $active ?? '';

if ($role === 'admin') {
    $brand    = 'Administration Mobile Money';
    $brandUrl = site_url('admin/dashboard');
    $links = [
        'dashboard'  => ['Tableau de bord', site_url('admin/dashboard')],
        'operateurs' => ['Opérateurs', site_url('admin/type-operateurs')],
        'prefixes'   => ['Préfixes', site_url('admin/prefixes')],
        'types'      => ['Types d’opérations', site_url('admin/type-transactions')],
        'relations'  => ['Relations', site_url('admin/relation-operateurs')],
        'baremes'    => ['Barèmes et gains', site_url('admin/baremesFrais')],
        'comptes'    => ['Comptes clients', site_url('admin/listComptes')],
        'mouvements' => ['Mouvements externes', site_url('admin/mouvements-autres-operateurs')],
    ];
} else {
    $brand    = 'huhu';
    $brandUrl = base_url('/');
    $links = [
        'dashboard'   => ['Tableau de bord', base_url('/')],
        'depot'       => ['Dépôt', base_url('depot')],
        'retrait'     => ['Retrait', base_url('retrait')],
        'transfert'   => ['Transfert', base_url('transfert')],
        'transfert_multiple' => ['Transfert multiple', base_url('transfert-multiple')],
        'transaction' => ['Historique', base_url('transaction')],
    ];
}
?>
<nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background-color:#123a68;">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="<?= $brandUrl ?>"><?= esc($brand) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Basculer la navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto">
                <?php foreach ($links as $key => [$label, $url]): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= $active === $key ? ' active fw-semibold' : '' ?>" href="<?= $url ?>"><?= esc($label) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (in_array($role, ['client', 'admin'], true)): ?>
                <button type="button" id="btnDeconnexionHeader" class="btn btn-outline-light btn-sm">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Déconnexion
                </button>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php if (in_array($role, ['client', 'admin'], true)): ?>
    <script>
        (function() {
            const btn = document.getElementById('btnDeconnexionHeader');
            if (!btn) return;
            btn.addEventListener('click', async function() {
                try {
                    const response = await fetch("<?= $role === 'admin' ? site_url('admin/logout') : base_url('logout') ?>", {
                        method: 'POST'
                    });
                    const data = await response.json();
                    if (response.ok && (data.status === 'success' || data.success === true)) {
                        window.location.href = "<?= $role === 'admin' ? site_url('admin/login') : base_url('login') ?>";
                    }
                } catch (e) {
                    /* silencieux */
                }
            });
        })();
    </script>
<?php endif; ?>
