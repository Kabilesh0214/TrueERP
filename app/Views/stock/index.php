<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">📦</div>
        <div>
            <h1>Stock & Inventory</h1>
            <p>Item Master, Warehouses, Stock Levels, and Valuation</p>
        </div>
    </div>
    <div class="header-actions">
        <a href="<?= url('/items/create') ?>" class="btn btn-primary">➕ New Item</a>
        <button class="btn btn-secondary" onclick="switchErpTab('tab-new-wh')">➕ New Warehouse</button>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-items')">📦 Item Master (<?= count($items) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-warehouses')">🏢 Warehouses (<?= count($warehouses) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-lowstock')">⚠️ Low Stock Alerts (<?= $lowStockCount ?>)</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Inventory Valuation (Cost)</div>
        <div class="stat-value" style="color: var(--primary);">$<?= number_format($totalValuation, 2) ?></div>
        <div class="stat-desc">Total asset value on hand</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Catalog SKUs</div>
        <div class="stat-value"><?= count($items) ?></div>
        <div class="stat-desc">Tracked inventory lines</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Low Stock Items</div>
        <div class="stat-value" style="color: <?= $lowStockCount > 0 ? 'var(--danger)' : 'var(--success)' ?>;"><?= $lowStockCount ?></div>
        <div class="stat-desc">Below safety threshold (20)</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Active Warehouses</div>
        <div class="stat-value"><?= count($warehouses) ?></div>
        <div class="stat-desc">Storage depots</div>
    </div>
</div>

<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-items')">📦 Item Master</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-warehouses')">🏢 Warehouses (<?= count($warehouses) ?>)</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-lowstock')">⚠️ Low Stock</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-wh')">➕ Register Warehouse</button>
</div>

<div id="tab-items" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>Inventory Catalog</h3>
            <a href="<?= url('/items/create') ?>" class="btn btn-primary btn-sm">➕ Add Item</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit Cost</th>
                    <th>Unit Price</th>
                    <th>Stock Qty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><code><?= e($item['code']) ?></code></td>
                        <td><strong><?= e($item['name']) ?></strong></td>
                        <td><?= e($item['category']) ?></td>
                        <td>$<?= number_format((float)$item['cost_price'], 2) ?></td>
                        <td><strong>$<?= number_format((float)$item['unit_price'], 2) ?></strong></td>
                        <td>
                            <span class="badge badge-<?= (int)$item['stock_quantity'] > 20 ? 'success' : 'danger' ?>">
                                <?= (int)$item['stock_quantity'] ?> <?= e($item['unit']) ?>
                            </span>
                        </td>
                        <td><a href="<?= url('/items/edit?id=' . $item['id']) ?>" class="btn btn-secondary btn-sm">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-warehouses" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Fulfillment & Storage Depots</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-wh')">➕ Add Warehouse</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Facility Name</th>
                    <th>Location</th>
                    <th>Site Manager</th>
                    <th>Capacity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($warehouses as $wh): ?>
                    <tr>
                        <td><strong><?= e($wh['name']) ?></strong></td>
                        <td><?= e($wh['location'] ?? '-') ?></td>
                        <td><?= e($wh['manager'] ?? 'Operations Team') ?></td>
                        <td><?= number_format((int)($wh['capacity_sqft'] ?? 0)) ?> sq.ft</td>
                        <td><span class="badge badge-success"><?= e($wh['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-lowstock" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Items Below Safety Reorder Point (&lt; 20 units)</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Current Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $hasLow = false;
                foreach ($items as $item): 
                    if ((int)$item['stock_quantity'] < 20):
                        $hasLow = true;
                ?>
                    <tr>
                        <td><code><?= e($item['code']) ?></code></td>
                        <td><strong><?= e($item['name']) ?></strong></td>
                        <td><?= e($item['category']) ?></td>
                        <td><span class="badge badge-danger"><?= (int)$item['stock_quantity'] ?> <?= e($item['unit']) ?> Remaining</span></td>
                        <td><a href="<?= url('/buying') ?>" class="btn btn-primary btn-sm">Raise PO</a></td>
                    </tr>
                <?php 
                    endif;
                endforeach; 
                if (!$hasLow):
                ?>
                    <tr><td colspan="5" style="text-align: center; color: var(--text-muted);">All inventory items are currently above safety thresholds.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-new-wh" class="erp-tab-pane">
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>Register Storage Facility</h3>
        </div>
        <form action="<?= url('/stock/warehouses/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Warehouse Name *</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. West Coast Distribution" required>
            </div>
            <div class="form-group">
                <label>Location / Address</label>
                <input type="text" name="location" class="form-control" placeholder="City, State, Facility Code">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Facility Manager</label>
                    <input type="text" name="manager" class="form-control" placeholder="Staff Name">
                </div>
                <div class="form-group">
                    <label>Capacity (sq. ft)</label>
                    <input type="number" name="capacity_sqft" class="form-control" value="25000">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Warehouse</button>
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
