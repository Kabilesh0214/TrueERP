<div class="page-title-bar">
    <div>
        <h2>Add New Customer</h2>
        <p>Create a new client profile for orders and billing.</p>
    </div>
    <a href="<?= url('/customers') ?>" class="btn btn-secondary">&larr; Back to Customers</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/customers/store') ?>">
        <div class="form-group">
            <label class="form-label" for="name">Contact / Client Name *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Michael Scott" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="company">Company / Business Name</label>
            <input type="text" id="company" name="company" class="form-control" placeholder="e.g. Dunder Mifflin Inc.">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="client@domain.com">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="+1-555-0199">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Billing / Shipping Address</label>
            <textarea id="address" name="address" class="form-control" rows="3" placeholder="Street, Suite, City, State, ZIP"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Customer</button>
    </form>
</div>
