<div class="page-title-bar">
    <div>
        <h2>Add New Inventory Item</h2>
        <p>Register a new SKU with price and initial stock.</p>
    </div>
    <a href="<?= url('/items') ?>" class="btn btn-secondary">&larr; Back to Items</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/items/store') ?>">
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="code">SKU / Item Code *</label>
                <input type="text" id="code" name="code" class="form-control" placeholder="e.g. ITM-105" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="category">Category</label>
                <select id="category" name="category" class="form-control">
                    <option value="Electronics">Electronics</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Supplies">Supplies</option>
                    <option value="Raw Materials">Raw Materials</option>
                    <option value="Services">Services</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Item Name / Title *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Ultra HD 4K Monitor 27 inch" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="unit_price">Selling Price ($) *</label>
                <input type="number" step="0.01" id="unit_price" name="unit_price" class="form-control" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="cost_price">Cost Price ($)</label>
                <input type="number" step="0.01" id="cost_price" name="cost_price" class="form-control" placeholder="0.00">
            </div>

            <div class="form-group">
                <label class="form-label" for="stock_quantity">Initial Stock Quantity</label>
                <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" value="0">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Inventory Item</button>
    </form>
</div>
