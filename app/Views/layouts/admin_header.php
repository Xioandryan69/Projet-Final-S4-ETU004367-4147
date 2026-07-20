<style>
    .admin-header{background:#123a68;color:#fff;padding:0 5%;box-shadow:0 2px 8px rgba(18,58,104,.2)}
    .admin-header__inner{max-width:1250px;margin:auto;min-height:64px;display:flex;align-items:center;gap:28px;flex-wrap:wrap}
    .admin-header__brand{color:#fff;font-weight:700;text-decoration:none;white-space:nowrap}
    .admin-header__nav{display:flex;gap:4px;flex-wrap:wrap}
    .admin-header__nav a{color:#e8f1fb;text-decoration:none;padding:9px 10px;border-radius:5px;font-size:.9rem}
    .admin-header__nav a:hover{background:rgba(255,255,255,.14);color:#fff}
    body > nav{display:none}
    body > header:not(.admin-header){display:none}
    @media(max-width:700px){.admin-header__inner{padding:12px 0;gap:10px}.admin-header__nav a{padding:7px;font-size:.82rem}}
</style>
<header class="admin-header">
    <div class="admin-header__inner">
        <a class="admin-header__brand" href="<?= site_url('admin/dashboard') ?>">Administration Mobile Money</a>
        <nav class="admin-header__nav" aria-label="Navigation administrateur">
            <a href="<?= site_url('admin/dashboard') ?>">Tableau de bord</a>
            <a href="<?= site_url('admin/type-operateurs') ?>">Opérateurs</a>
            <a href="<?= site_url('admin/prefixes') ?>">Préfixes</a>
            <a href="<?= site_url('admin/type-transactions') ?>">Types d’opérations</a>
            <a href="<?= site_url('admin/relation-operateurs') ?>">Relations</a>
            <a href="<?= site_url('admin/baremesFrais') ?>">Barèmes et gains</a>
            <a href="<?= site_url('admin/listComptes') ?>">Comptes clients</a>
        </nav>
    </div>
</header>
