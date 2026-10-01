<div class="page-title-bar">
    <div>
        <h2>Add New Supplier</h2>
        <p>Register a vendor for purchasing and inventory procurement.</p>
    </div>
    <a href="<?= url('/suppliers') ?>" class="btn btn-secondary">&larr; Back to Suppliers</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/suppliers/store') ?>">
        <div class="form-group">
            <label class="form-label" for="name">Supplier / Business Name *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Apex Logistics Co." required>
        </div>

        <div class="form-group">
            <label class="form-label" for="contact_person">Contact Person</label>
            <input type="text" id="contact_person" name="contact_person" class="form-control" placeholder="e.g. David Warner">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="sales@supplier.com">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="+1-555-0300">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Warehouse / Office Address</label>
            <textarea id="address" name="address" class="form-control" rows="3" placeholder="Full address details"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Supplier</button>
    </form>
</div>
