<div class="page-title-bar">
    <div>
        <h2>Customer Accounts (CRM)</h2>
        <p>Manage customer contacts, billing addresses, and client accounts.</p>
    </div>
    <a href="<?= url('/customers/create') ?>" class="btn btn-primary">+ Add New Customer</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($customers)): ?>
                <tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">No customers found. <a href="<?= url('/customers/create') ?>">Add your first customer</a>.</td></tr>
            <?php else: ?>
                <?php foreach ($customers as $c): ?>
                    <tr>
                        <td>#<?= $c['id'] ?></td>
                        <td><strong><?= e($c['name']) ?></strong></td>
                        <td><?= e($c['company'] ?: '—') ?></td>
                        <td><?= e($c['email'] ?: '—') ?></td>
                        <td><?= e($c['phone'] ?: '—') ?></td>
                        <td><small><?= e($c['address'] ?: '—') ?></small></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?= url('/customers/edit?id=' . $c['id']) ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="<?= url('/customers/delete') ?>" onsubmit="return confirm('Delete this customer?');">
                                    <input type="hidden" name="id" value="<?= $c['id'] ?>">
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
