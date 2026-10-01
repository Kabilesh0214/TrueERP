<div class="page-title-bar">
    <div>
        <h2>Edit User: <?= e($user['name']) ?></h2>
        <p>Update profile details, permissions, or password.</p>
    </div>
    <a href="<?= url('/users') ?>" class="btn btn-secondary">&larr; Back to Users</a>
</div>

<div class="card" style="max-width: 650px;">
    <form method="POST" action="<?= url('/users/update') ?>">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= e($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= e($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">New Password (optional)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep existing password">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="role">User Role</label>
                <select id="role" name="role" class="form-control">
                    <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="manager" <?= $user['role'] === 'manager' ? 'selected' : '' ?>>Manager</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Administrator</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Account Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
