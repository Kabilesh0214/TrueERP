<div class="page-title-bar">
    <div>
        <h2>Dashboard Overview</h2>
        <p>Welcome back, <strong><?= e($user['name'] ?? 'User') ?></strong>. Here is what is happening today.</p>
    </div>
    <div class="no-print">
        <a href="<?= url('/sales/create') ?>" class="btn btn-primary">+ New Sales Invoice</a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div>
            <div class="stat-value"><?= $stats['total_customers'] ?></div>
            <div class="stat-label">Customers</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">🏭</div>
        <div>
            <div class="stat-value"><?= $stats['total_suppliers'] ?></div>
            <div class="stat-label">Suppliers</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">📦</div>
        <div>
            <div class="stat-value"><?= $stats['total_items'] ?></div>
            <div class="stat-label">Inventory Items</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon amber">🧾</div>
        <div>
            <div class="stat-value"><?= $stats['total_sales'] ?></div>
            <div class="stat-label">Sales Invoices</div>
        </div>
    </div>

    <?php if (($user['role'] ?? '') === 'admin'): ?>
        <div class="stat-card">
            <div class="stat-icon indigo">⚙️</div>
            <div>
                <div class="stat-value"><?= $stats['total_users'] ?></div>
                <div class="stat-label">System Users</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-header">
        <h3>Recent Sales Invoices</h3>
        <a href="<?= url('/sales') ?>" class="btn btn-secondary btn-sm">View All Invoices →</a>
    </div>

    <?php if (empty($recentSales)): ?>
        <p style="color: var(--text-muted); text-align: center; padding: 2rem;">No sales invoices generated yet. <a href="<?= url('/sales/create') ?>">Create your first invoice</a>.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentSales as $sale): ?>
                        <tr>
                            <td><strong><?= e($sale['invoice_number']) ?></strong></td>
                            <td><?= e($sale['customer_name'] ?? '—') ?></td>
                            <td><?= e($sale['invoice_date']) ?></td>
                            <td><strong>$<?= number_format((float)$sale['total_amount'], 2) ?></strong></td>
                            <td>
                                <span class="badge <?= $sale['status'] === 'paid' ? 'badge-success' : 'badge-warning' ?>">
                                    <?= e($sale['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= url('/sales/show?id=' . $sale['id']) ?>" class="btn btn-secondary btn-sm">View Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
