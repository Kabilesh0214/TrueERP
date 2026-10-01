<div class="page-title-bar">
    <div>
        <h2>Edit Item: <?= e($item['name']) ?></h2>
        <p>Update pricing, SKU code, or inventory stock.</p>
    </div>
    <a href="<?= url('/items') ?>" class="btn btn-secondary">&larr; Back to Items</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/items/update') ?>">
        <input type="hidden" name="id" value="<?= $item['id'] ?>">

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="code">SKU / Item Code *</label>
                <input type="text" id="code" name="code" class="form-control" value="<?= e($item['code']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="category">Category</label>
                <select id="category" name="category" class="form-control">
                    <option value="Electronics" <?= $item['category'] === 'Electronics' ? 'selected' : '' ?>>Electronics</option>
                    <option value="Furniture" <?= $item['category'] === 'Furniture' ? 'selected' : '' ?>>Furniture</option>
                    <option value="Supplies" <?= $item['category'] === 'Supplies' ? 'selected' : '' ?>>Supplies</option>
                    <option value="Raw Materials" <?= $item['category'] === 'Raw Materials' ? 'selected' : '' ?>>Raw Materials</option>
                    <option value="Services" <?= $item['category'] === 'Services' ? 'selected' : '' ?>>Services</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Item Name / Title *</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= e($item['name']) ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="unit_price">Selling Price ($) *</label>
                <input type="number" step="0.01" id="unit_price" name="unit_price" class="form-control" value="<?= e($item['unit_price']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="cost_price">Cost Price ($)</label>
                <input type="number" step="0.01" id="cost_price" name="cost_price" class="form-control" value="<?= e($item['cost_price']) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="stock_quantity">Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" value="<?= e($item['stock_quantity']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
