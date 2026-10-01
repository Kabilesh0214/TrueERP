<div class="page-title-bar">
    <div>
        <h2>Edit Supplier: <?= e($supplier['name']) ?></h2>
        <p>Update vendor contact and logistics info.</p>
    </div>
    <a href="<?= url('/suppliers') ?>" class="btn btn-secondary">&larr; Back to Suppliers</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/suppliers/update') ?>">
        <input type="hidden" name="id" value="<?= $supplier['id'] ?>">

        <div class="form-group">
            <label class="form-label" for="name">Supplier / Business Name *</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= e($supplier['name']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="contact_person">Contact Person</label>
            <input type="text" id="contact_person" name="contact_person" class="form-control" value="<?= e($supplier['contact_person'] ?? '') ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e($supplier['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= e($supplier['phone'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Warehouse / Office Address</label>
            <textarea id="address" name="address" class="form-control" rows="3"><?= e($supplier['address'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Supplier</button>
    </form>
</div>
