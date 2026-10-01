<div class="page-title-bar">
    <div>
        <h2>Edit Customer: <?= e($customer['name']) ?></h2>
        <p>Update customer contact and business information.</p>
    </div>
    <a href="<?= url('/customers') ?>" class="btn btn-secondary">&larr; Back to Customers</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/customers/update') ?>">
        <input type="hidden" name="id" value="<?= $customer['id'] ?>">

        <div class="form-group">
            <label class="form-label" for="name">Contact / Client Name *</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= e($customer['name']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="company">Company / Business Name</label>
            <input type="text" id="company" name="company" class="form-control" value="<?= e($customer['company'] ?? '') ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= e($customer['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= e($customer['phone'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Billing / Shipping Address</label>
            <textarea id="address" name="address" class="form-control" rows="3"><?= e($customer['address'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Customer</button>
    </form>
</div>
