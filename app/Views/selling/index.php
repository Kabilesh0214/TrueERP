<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">🛍️</div>
        <div>
            <h1>Selling Workspace</h1>
            <p>Customers, Sales Quotations, Sales Orders, and Invoicing Pipeline</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="<?= url('/sales/create') ?>" class="btn btn-primary">➕ New Sales Invoice</a>
        <a href="<?= url('/customers/create') ?>" class="btn btn-secondary">➕ New Customer</a>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-sell-invoices')">🧾 Invoices (<?= count($invoices) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-sell-customers')">👥 Customers (<?= count($customers) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-sell-items')">📦 Catalog Items (<?= count($items) ?>)</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Sales Revenue</div>
        <div class="stat-value" style="color: var(--primary);">$<?= number_format($totalRevenue, 2) ?></div>
        <div class="stat-desc">From <?= $totalOrders ?> orders</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Customers</div>
        <div class="stat-value"><?= count($customers) ?></div>
        <div class="stat-desc">Active client accounts</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Catalog Products</div>
        <div class="stat-value"><?= count($items) ?></div>
        <div class="stat-desc">Billable items</div>
    </div>
</div>

<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-sell-invoices')">🧾 Sales Invoices</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-sell-customers')">👥 Customers Directory</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-sell-items')">📦 Selling Item Catalog</button>
</div>

<div id="tab-sell-invoices" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>Sales Invoices</h3>
            <a href="<?= url('/sales/create') ?>" class="btn btn-primary btn-sm">➕ Create Invoice</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $inv): ?>
                    <tr>
                        <td><strong><?= e($inv['invoice_number']) ?></strong></td>
                        <td><?= e($inv['customer_name'] ?? 'N/A') ?></td>
                        <td><?= e($inv['invoice_date']) ?></td>
                        <td><strong>$<?= number_format((float)$inv['total_amount'], 2) ?></strong></td>
                        <td><span class="badge badge-<?= $inv['status'] === 'paid' ? 'success' : 'warning' ?>"><?= strtoupper(e($inv['status'])) ?></span></td>
                        <td><a href="<?= url('/sales/show?id=' . $inv['id']) ?>" class="btn btn-secondary btn-sm">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-sell-customers" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Customer Accounts</h3>
            <a href="<?= url('/customers/create') ?>" class="btn btn-primary btn-sm">➕ Add Customer</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $c): ?>
                    <tr>
                        <td><strong><?= e($c['name']) ?></strong></td>
                        <td><?= e($c['company'] ?? '-') ?></td>
                        <td><?= e($c['email'] ?? '-') ?></td>
                        <td><?= e($c['phone'] ?? '-') ?></td>
                        <td><a href="<?= url('/customers/edit?id=' . $c['id']) ?>" class="btn btn-secondary btn-sm">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-sell-items" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Available Products</h3>
            <a href="<?= url('/items/create') ?>" class="btn btn-primary btn-sm">➕ Add Item</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>SKU Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Selling Price</th>
                    <th>Available Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><code><?= e($item['code']) ?></code></td>
                        <td><strong><?= e($item['name']) ?></strong></td>
                        <td><?= e($item['category']) ?></td>
                        <td><strong style="color: var(--primary);">$<?= number_format((float)$item['unit_price'], 2) ?></strong></td>
                        <td><span class="badge badge-<?= (int)$item['stock_quantity'] > 20 ? 'success' : 'danger' ?>"><?= (int)$item['stock_quantity'] ?> <?= e($item['unit']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function switchErpTab(tabId) {
    document.querySelectorAll('.erp-tab-pane').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.erp-tab-btn').forEach(el => el.classList.remove('active'));
    const pane = document.getElementById(tabId);
    if (pane) pane.classList.add('active');
    const btn = Array.from(document.querySelectorAll('.erp-tab-btn')).find(b => b.getAttribute('onclick')?.includes(tabId));
    if (btn) btn.classList.add('active');
}
</script>
