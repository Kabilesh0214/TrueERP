<div class="page-title-bar">
    <div>
        <h2>Create Sales Invoice</h2>
        <p>Select customer, add inventory items, and calculate totals.</p>
    </div>
    <a href="<?= url('/sales') ?>" class="btn btn-secondary">&larr; Back to Invoices</a>
</div>

<form method="POST" action="<?= url('/sales/store') ?>">
    <div class="card">
        <div class="card-header">
            <h3>1. Invoice &amp; Customer Information</h3>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="customer_id">Select Customer *</label>
                <select id="customer_id" name="customer_id" class="form-control" required>
                    <option value="">-- Choose Customer --</option>
                    <?php foreach ($customers as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= e($c['name']) ?> (<?= e($c['company'] ?: 'Individual') ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="due_date">Payment Due Date</label>
                <input type="date" id="due_date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="notes">Notes / Terms</label>
            <textarea id="notes" name="notes" class="form-control" rows="2" placeholder="e.g. Net 30 payment terms via wire transfer"></textarea>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>2. Invoice Line Items</h3>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Select Product / Item</th>
                        <th style="width: 140px;">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                        <tr>
                            <td><strong><?= $i + 1 ?></strong></td>
                            <td>
                                <select name="item_id[]" class="form-control">
                                    <option value="">-- Select Product (Optional) --</option>
                                    <?php foreach ($items as $item): ?>
                                        <option value="<?= $item['id'] ?>">
                                            <?= e($item['code']) ?> - <?= e($item['name']) ?> ($<?= number_format((float)$item['unit_price'], 2) ?> | In Stock: <?= $item['stock_quantity'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control" value="1" min="1">
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">Generate Invoice &amp; Deduct Stock</button>
        </div>
    </div>
</form>
