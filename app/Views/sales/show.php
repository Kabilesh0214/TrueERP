<div class="page-title-bar no-print">
    <div>
        <h2>Sales Invoice: <?= e($invoice['invoice_number']) ?></h2>
        <p>Status: <span class="badge <?= $invoice['status'] === 'paid' ? 'badge-success' : 'badge-warning' ?>"><?= strtoupper(e($invoice['status'])) ?></span></p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="<?= url('/sales') ?>" class="btn btn-secondary">&larr; Back to Invoices</a>
        <button onclick="window.print()" class="btn btn-primary">🖨 Print Invoice</button>
    </div>
</div>

<div class="invoice-box">
    <div class="invoice-header-grid">
        <div>
            <h2 style="color: var(--primary); margin-bottom: 0.5rem;">PHP ERP</h2>
            <p style="color: var(--text-muted); font-size: 0.85rem;">
                Enterprise Resource Planning<br>
                100 Innovation Parkway, Suite 500<br>
                accounts@phperp.local
            </p>

            <div style="margin-top: 1.5rem;">
                <div class="stat-label">Billed To</div>
                <h3 style="margin-top: 0.25rem;"><?= e($invoice['customer_name']) ?></h3>
                <div style="color: var(--text-muted); font-size: 0.875rem;">
                    <?= e($invoice['customer_company'] ?: '') ?><br>
                    <?= e($invoice['customer_email'] ?: '') ?><br>
                    <?= e($invoice['customer_phone'] ?: '') ?><br>
                    <?= nl2br(e($invoice['customer_address'] ?: '')) ?>
                </div>
            </div>
        </div>

        <div style="text-align: right;">
            <h1 style="font-size: 1.75rem; color: var(--text-main); margin-bottom: 0.5rem;">INVOICE</h1>
            <div style="font-size: 1.1rem; font-weight: 700; color: var(--primary);"><?= e($invoice['invoice_number']) ?></div>
            <div style="margin-top: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                <strong>Invoice Date:</strong> <?= e($invoice['invoice_date']) ?><br>
                <strong>Due Date:</strong> <?= e($invoice['due_date'] ?: 'Upon Receipt') ?><br>
                <strong>Payment Status:</strong> <?= strtoupper(e($invoice['status'])) ?>
            </div>
        </div>
    </div>

    <div class="table-responsive" style="box-shadow: none; border-radius: var(--radius-sm); margin-bottom: 1.5rem;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>SKU Code</th>
                    <th>Item Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Line Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $idx = 1; foreach ($invoice['items'] as $item): ?>
                    <tr>
                        <td><?= $idx++ ?></td>
                        <td><code><?= e($item['item_code']) ?></code></td>
                        <td><strong><?= e($item['item_name']) ?></strong></td>
                        <td style="text-align: center;"><?= $item['quantity'] ?></td>
                        <td style="text-align: right;">$<?= number_format((float)$item['unit_price'], 2) ?></td>
                        <td style="text-align: right;"><strong>$<?= number_format((float)$item['total_price'], 2) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background: #f8fafc;">
                    <td colspan="5" style="text-align: right; font-weight: 700; font-size: 1rem;">Grand Total:</td>
                    <td style="text-align: right; font-weight: 800; font-size: 1.15rem; color: var(--primary);">$<?= number_format((float)$invoice['total_amount'], 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php if (!empty($invoice['notes'])): ?>
        <div style="padding: 1rem; background: var(--bg-body); border-radius: var(--radius-sm); font-size: 0.85rem;">
            <strong>Payment Terms &amp; Instructions:</strong>
            <p style="color: var(--text-muted); margin-top: 0.25rem;"><?= nl2br(e($invoice['notes'])) ?></p>
        </div>
    <?php endif; ?>
</div>
