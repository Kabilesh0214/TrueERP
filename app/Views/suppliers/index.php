<div class="page-title-bar">
    <div>
        <h2>Suppliers &amp; Vendors (Buying)</h2>
        <p>Manage raw material suppliers, equipment vendors, and logistics partners.</p>
    </div>
    <a href="<?= url('/suppliers/create') ?>" class="btn btn-primary">+ Add New Supplier</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Supplier Company</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($suppliers)): ?>
                <tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">No suppliers found. <a href="<?= url('/suppliers/create') ?>">Add your first supplier</a>.</td></tr>
            <?php else: ?>
                <?php foreach ($suppliers as $s): ?>
                    <tr>
                        <td>#<?= $s['id'] ?></td>
                        <td><strong><?= e($s['name']) ?></strong></td>
                        <td><?= e($s['contact_person'] ?: '—') ?></td>
                        <td><?= e($s['email'] ?: '—') ?></td>
                        <td><?= e($s['phone'] ?: '—') ?></td>
                        <td><small><?= e($s['address'] ?: '—') ?></small></td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?= url('/suppliers/edit?id=' . $s['id']) ?>" class="btn btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="<?= url('/suppliers/delete') ?>" onsubmit="return confirm('Delete this supplier?');">
                                    <input type="hidden" name="id" value="<?= $s['id'] ?>">
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
