<div class="page-title-bar">
    <div>
        <h2>Create System User</h2>
        <p>Add a new employee or administrator account to PHP ERP.</p>
    </div>
    <a href="<?= url('/users') ?>" class="btn btn-secondary">&larr; Back to Users</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/users/store') ?>">
        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="sarah@company.com" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Login Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="At least 6 characters" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="role">User Role</label>
                <select id="role" name="role" class="form-control">
                    <option value="staff">Staff (Sales & Items)</option>
                    <option value="manager">Manager (Operations)</option>
                    <option value="admin">Administrator (Full Access)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Account Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">Create User Account</button>
        </div>
    </form>
</div>
