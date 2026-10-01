<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">🛒</div>
        <div>
            <h1>Buying & Procurement</h1>
            <p>Purchase Orders, Material Requests, and Vendor Management</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" onclick="switchErpTab('tab-new-po')">➕ New Purchase Order</button>
        <a href="<?= url('/suppliers/create') ?>" class="btn btn-secondary">➕ New Supplier</a>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-pos')">📋 Purchase Orders (<?= count($purchaseOrders) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-suppliers')">🏭 Suppliers (<?= count($suppliers) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-new-po')">➕ Create PO</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Procurement Spend</div>
        <div class="stat-value" style="color: var(--danger);">$<?= number_format($totalSpend, 2) ?></div>
        <div class="stat-desc">Cumulative PO value</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Open Purchase Orders</div>
        <div class="stat-value" style="color: var(--warning);"><?= $openOrders ?></div>
        <div class="stat-desc">Awaiting fulfillment</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Active Suppliers</div>
        <div class="stat-value"><?= count($suppliers) ?></div>
        <div class="stat-desc">Approved vendors</div>
    </div>
</div>

<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-pos')">📋 Purchase Orders</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-suppliers')">🏭 Supplier Directory</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-po')">➕ New Purchase Order</button>
</div>

<div id="tab-pos" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>Purchase Orders</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-po')">➕ Create PO</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>PO Number</th>
                    <th>Supplier</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchaseOrders as $po): ?>
                    <tr>
                        <td><strong><?= e($po['po_number']) ?></strong></td>
                        <td><?= e($supplierMap[$po['supplier_id']] ?? 'Supplier #' . $po['supplier_id']) ?></td>
                        <td><?= e($po['order_date']) ?></td>
                        <td><strong>$<?= number_format((float)$po['total_amount'], 2) ?></strong></td>
                        <td>
                            <span class="badge badge-<?= $po['status'] === 'Received' ? 'success' : 'info' ?>">
                                <?= e($po['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-suppliers" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Registered Suppliers</h3>
            <a href="<?= url('/suppliers/create') ?>" class="btn btn-primary btn-sm">➕ Add Supplier</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Supplier Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $s): ?>
                    <tr>
                        <td><strong><?= e($s['name']) ?></strong></td>
                        <td><?= e($s['contact_person'] ?? '-') ?></td>
                        <td><?= e($s['email'] ?? '-') ?></td>
                        <td><?= e($s['phone'] ?? '-') ?></td>
                        <td><a href="<?= url('/suppliers/edit?id=' . $s['id']) ?>" class="btn btn-secondary btn-sm">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-new-po" class="erp-tab-pane">
    <div class="card" style="max-width: 650px;">
        <div class="card-header">
            <h3>Draft Purchase Order</h3>
        </div>
        <form action="<?= url('/buying/po/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Target Supplier *</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">-- Choose Vendor --</option>
                    <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= e($s['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Order Date *</label>
                    <input type="date" name="order_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label>Total PO Amount ($) *</label>
                    <input type="number" step="0.01" name="total_amount" class="form-control" placeholder="0.00" required>
                </div>
            </div>
            <div class="form-group">
                <label>Order Status</label>
                <select name="status" class="form-control">
                    <option value="Ordered">Ordered (Pending Delivery)</option>
                    <option value="Draft">Draft</option>
                    <option value="Received">Received & Inspected</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes / Specifications</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Enter delivery terms or line item summary..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Purchase Order</button>
        </form>
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
