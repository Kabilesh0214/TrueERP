<header class="app-header">
    <div class="header-brand">
        <div class="brand-icon">ERP</div>
        <span>PHP ERP System</span>
    </div>
    <div class="header-user">
        <div class="user-pill">
            <span>👤</span>
            <strong><?= e($currentUser['name'] ?? 'User') ?></strong>
            <span class="badge badge-primary"><?= e($currentUser['role'] ?? 'staff') ?></span>
        </div>
        <a href="<?= url('/logout') ?>" class="btn btn-secondary btn-sm">Sign Out</a>
    </div>
</header>
