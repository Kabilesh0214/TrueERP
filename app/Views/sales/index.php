<div class="page-title-bar">
    <div>
        <h2>Sales Invoices</h2>
        <p>Generate, review, and print customer sales orders and invoices.</p>
    </div>
    <a href="<?= url('/sales/create') ?>" class="btn btn-primary">+ Create Sales Invoice</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Company</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Grand Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($invoices)): ?>
                <tr><td colspan="8" style="text-align: center; color: var(--text-muted); padding: 2rem;">No invoices created yet. <a href="<?= url('/sales/create') ?>">Generate your first invoice</a>.</td></tr>
            <?php else: ?>
                <?php foreach ($invoices as $inv): ?>
                    <tr>
                        <td><strong><?= e($inv['invoice_number']) ?></strong></td>
                        <td><?= e($inv['customer_name'] ?? '—') ?></td>
                        <td><?= e($inv['customer_company'] ?: '—') ?></td>
                        <td><?= e($inv['invoice_date']) ?></td>
                        <td><?= e($inv['due_date'] ?: '—') ?></td>
                        <td><strong>$<?= number_format((float)$inv['total_amount'], 2) ?></strong></td>
                        <td>
                            <span class="badge <?= $inv['status'] === 'paid' ? 'badge-success' : 'badge-warning' ?>">
                                <?= e($inv['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= url('/sales/show?id=' . $inv['id']) ?>" class="btn btn-secondary btn-sm">View &amp; Print</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
