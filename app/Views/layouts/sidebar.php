<?php 
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
if ($scriptDir !== '' && str_starts_with($currentUri, $scriptDir)) {
    $currentUri = substr($currentUri, strlen($scriptDir));
}
$currentUri = rtrim($currentUri, '/') ?: '/';
?>
<aside class="app-sidebar">
    <div class="sidebar-heading">Core Modules</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?= url('/dashboard') ?>" class="<?= in_array($currentUri, ['/', '/dashboard']) ? 'active' : '' ?>">
                <span>📊</span> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= url('/customers') ?>" class="<?= str_starts_with($currentUri, '/customers') ? 'active' : '' ?>">
                <span>👥</span> Customers (CRM)
            </a>
        </li>
        <li>
            <a href="<?= url('/suppliers') ?>" class="<?= str_starts_with($currentUri, '/suppliers') ? 'active' : '' ?>">
                <span>🏭</span> Suppliers (Buying)
            </a>
        </li>
        <li>
            <a href="<?= url('/items') ?>" class="<?= str_starts_with($currentUri, '/items') ? 'active' : '' ?>">
                <span>📦</span> Items (Stock)
            </a>
        </li>
        <li>
            <a href="<?= url('/sales') ?>" class="<?= str_starts_with($currentUri, '/sales') ? 'active' : '' ?>">
                <span>🧾</span> Sales Invoices
            </a>
        </li>
    </ul>

    <?php if (($currentUser['role'] ?? '') === 'admin'): ?>
        <div class="sidebar-heading">Administration</div>
        <ul class="sidebar-nav">
            <li>
                <a href="<?= url('/users') ?>" class="<?= str_starts_with($currentUri, '/users') ? 'active' : '' ?>">
                    <span>⚙️</span> System Users
                </a>
            </li>
        </ul>
    <?php endif; ?>
</aside>
