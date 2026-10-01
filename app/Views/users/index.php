<div class="page-title-bar">
    <div>
        <h2>User Management</h2>
        <p>Manage system administrators, managers, and staff accounts.</p>
    </div>
    <a href="<?= url('/users/create') ?>" class="btn btn-primary">+ Add New User</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>Role</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td>#<?= $u['id'] ?></td>
                    <td><strong><?= e($u['name']) ?></strong></td>
                    <td><?= e($u['email']) ?></td>
                    <td>
                        <span class="badge <?= $u['role'] === 'admin' ? 'badge-primary' : 'badge-neutral' ?>">
                            <?= e($u['role']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge <?= $u['status'] === 'active' ? 'badge-success' : 'badge-danger' ?>">
                            <?= e($u['status']) ?>
                        </span>
                    </td>
                    <td><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="<?= url('/users/edit?id=' . $u['id']) ?>" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="<?= url('/users/delete') ?>" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
