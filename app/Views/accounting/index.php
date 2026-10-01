<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">💰</div>
        <div>
            <h1>Accounting & Finance</h1>
            <p>Ledgers, Accounts Receivable, Sales Invoices, and Payment Entries</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" onclick="switchErpTab('tab-new-payment')">➕ Record Payment</button>
        <a href="<?= url('/sales/create') ?>" class="btn btn-secondary">➕ New Sales Invoice</a>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-invoices')">🧾 Invoices (<?= count($invoices) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-payments')">💳 Payments (<?= count($payments) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-coa')">🏛️ Chart of Accounts</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-new-payment')">➕ Record Payment</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Accounts Receivable (Pending)</div>
        <div class="stat-value" style="color: var(--warning);">$<?= number_format($totalReceivables, 2) ?></div>
        <div class="stat-desc"><?= $pendingCount ?> unpaid/pending invoices</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Payments Collected</div>
        <div class="stat-value" style="color: var(--success);">$<?= number_format($totalPaid, 2) ?></div>
        <div class="stat-desc">Bank & Card settlements</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Invoices Issued</div>
        <div class="stat-value"><?= count($invoices) ?></div>
        <div class="stat-desc">Billing documents</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Registered Customers</div>
        <div class="stat-value"><?= count($customers) ?></div>
        <div class="stat-desc">Active business debtors</div>
    </div>
</div>

<!-- ERPNext Tabs Navigation -->
<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-overview')">📊 Overview</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-invoices')">🧾 Sales Invoices (<?= count($invoices) ?>)</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-payments')">💳 Payment Entries (<?= count($payments) ?>)</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-coa')">🏛️ Chart of Accounts</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-payment')">➕ Record Payment</button>
</div>

<!-- Tab 1: Overview -->
<div id="tab-overview" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>Recent Financial Activity</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ref / Document</th>
                    <th>Entity</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($invoices, 0, 5) as $inv): ?>
                    <tr>
                        <td><strong><a href="<?= url('/sales/show?id=' . $inv['id']) ?>"><?= e($inv['invoice_number']) ?></a></strong></td>
                        <td><?= e($inv['customer_name'] ?? 'N/A') ?></td>
                        <td><?= e($inv['invoice_date']) ?></td>
                        <td><span class="badge badge-primary">Invoice</span></td>
                        <td><strong>$<?= number_format((float)$inv['total_amount'], 2) ?></strong></td>
                        <td>
                            <span class="badge badge-<?= $inv['status'] === 'paid' ? 'success' : 'warning' ?>">
                                <?= strtoupper(e($inv['status'])) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach (array_slice($payments, 0, 5) as $pay): ?>
                    <tr>
                        <td><strong><?= e($pay['payment_number']) ?></strong></td>
                        <td>Ref: <?= e($pay['reference'] ?? 'Direct') ?></td>
                        <td><?= e($pay['payment_date']) ?></td>
                        <td><span class="badge badge-success">Payment In</span></td>
                        <td style="color: var(--success);"><strong>+$<?= number_format((float)$pay['amount'], 2) ?></strong></td>
                        <td><span class="badge badge-success"><?= strtoupper(e($pay['status'] ?? 'COMPLETED')) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tab 2: Invoices -->
<div id="tab-invoices" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>All Sales Invoices</h3>
            <a href="<?= url('/sales/create') ?>" class="btn btn-primary btn-sm">➕ Create Invoice</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Invoice #</th>
                    <th>Customer</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Total ($)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $inv): ?>
                    <tr>
                        <td><strong><?= e($inv['invoice_number']) ?></strong></td>
                        <td><?= e($inv['customer_name'] ?? 'N/A') ?></td>
                        <td><?= e($inv['invoice_date']) ?></td>
                        <td><?= e($inv['due_date'] ?? 'Net 30') ?></td>
                        <td><strong>$<?= number_format((float)$inv['total_amount'], 2) ?></strong></td>
                        <td>
                            <span class="badge badge-<?= $inv['status'] === 'paid' ? 'success' : 'warning' ?>">
                                <?= strtoupper(e($inv['status'])) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= url('/sales/show?id=' . $inv['id']) ?>" class="btn btn-secondary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tab 3: Payments -->
<div id="tab-payments" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Payment Entries</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-payment')">➕ Record Payment</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $pay): ?>
                    <tr>
                        <td><strong><?= e($pay['payment_number']) ?></strong></td>
                        <td><?= e($pay['payment_date']) ?></td>
                        <td><span class="badge badge-info"><?= e($pay['payment_method']) ?></span></td>
                        <td><code><?= e($pay['reference'] ?? 'N/A') ?></code></td>
                        <td><strong style="color: var(--success);">$<?= number_format((float)$pay['amount'], 2) ?></strong></td>
                        <td><span class="badge badge-success"><?= strtoupper(e($pay['status'] ?? 'COMPLETED')) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Tab 4: Chart of Accounts -->
<div id="tab-coa" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Standard Chart of Accounts (COA)</h3>
        </div>
        <div style="padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem;">
                    <h4 style="color: var(--primary); margin-bottom: 0.75rem;">1000 - Assets</h4>
                    <ul style="list-style: none; font-size: 0.875rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li>📁 1100 - Current Assets</li>
                        <li style="padding-left: 1.25rem;">💵 1110 - Bank Accounts & Cash ($<?= number_format($totalPaid, 2) ?>)</li>
                        <li style="padding-left: 1.25rem;">📜 1120 - Accounts Receivable ($<?= number_format($totalReceivables, 2) ?>)</li>
                        <li>📁 1200 - Fixed Assets & Equipment</li>
                    </ul>
                </div>
                <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem;">
                    <h4 style="color: var(--warning); margin-bottom: 0.75rem;">2000 - Liabilities</h4>
                    <ul style="list-style: none; font-size: 0.875rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li>📁 2100 - Accounts Payable (Suppliers)</li>
                        <li>📁 2200 - Payroll Taxes & Deductions</li>
                        <li>📁 2300 - Accrued Operating Expenses</li>
                    </ul>
                </div>
                <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem;">
                    <h4 style="color: var(--success); margin-bottom: 0.75rem;">4000 - Income / Revenue</h4>
                    <ul style="list-style: none; font-size: 0.875rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li>📈 4100 - Direct Sales Revenue ($<?= number_format($totalReceivables + $totalPaid, 2) ?>)</li>
                        <li>📈 4200 - Consulting & Service Income</li>
                        <li>📈 4300 - Shipping & Handling Fees</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab 5: Record Payment -->
<div id="tab-new-payment" class="erp-tab-pane">
    <div class="card" style="max-width: 650px;">
        <div class="card-header">
            <h3>Record Inward Payment Entry</h3>
        </div>
        <form action="<?= url('/accounting/payments/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Select Associated Invoice (Optional)</label>
                <select name="invoice_id" class="form-control">
                    <option value="">-- Standalone Payment --</option>
                    <?php foreach ($invoices as $inv): ?>
                        <option value="<?= $inv['id'] ?>"><?= e($inv['invoice_number']) ?> - <?= e($inv['customer_name'] ?? 'Client') ?> ($<?= number_format((float)$inv['total_amount'], 2) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Amount Received ($) *</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Payment Date *</label>
                    <input type="date" name="payment_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="Bank Transfer">Bank Transfer (ACH / Wire)</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Corporate Cheque</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Transaction Reference / Check #</label>
                    <input type="text" name="reference" class="form-control" placeholder="e.g. TXN-893021">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Payment Entry</button>
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
