<div class="page-title-bar">
    <div>
        <h2>Inventory &amp; Stock Items</h2>
        <p>Track product SKUs, categories, selling prices, and stock balances.</p>
    </div>
    <a href="<?= url('/items/create') ?>" class="btn btn-primary">+ Add New Item</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Selling Price</th>
                <th>Cost Price</th>
                <th>Stock Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($items)): ?>
                <tr><td colspan="8" style="text-align: center; color: var(--text-muted); padding: 2rem;">No items in inventory. <a href="<?= url('/items/create') ?>">Add your first product</a>.</td></tr>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><code><?= e($item['code']) ?></code></td>
                        <td><strong><?= e($item['name']) ?></strong></td>
                        <td><span class="badge badge-neutral"><?= e($item['category'] ?: 'General') ?></span></td>
                        <td><?= e($item['unit'] ?? 'pcs') ?></td>
                        <td><strong>$<?= number_format((float)$item['unit_price'], 2) ?></strong></td>
                        <td style="color: var(--text-muted);">$<?= number_format((float)$item['cost_price'], 2) ?></td>
                        <td>
                            <?php if ($item['stock_quantity'] <= 5): ?>
                                <span class="badge badge-danger"><?= $item['stock_quantity'] ?> Low</span>
                            <?php else: ?>
                                <span class="badge badge-success"><?= $item['stock_quantity'] ?> in stock</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?= url('/items/edit?id=' . $item['id']) ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="<?= url('/items/delete') ?>" onsubmit="return confirm('Delete this item?');">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
