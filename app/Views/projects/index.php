<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">📁</div>
        <div>
            <h1>Project & Task Management</h1>
            <p>Milestones, Client Projects, Sprint Tasks, and Budgets</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" onclick="switchErpTab('tab-new-task')">➕ Log Task</button>
        <button class="btn btn-secondary" onclick="switchErpTab('tab-new-project')">➕ New Project</button>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-projects')">📁 Projects (<?= count($projects) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-tasks')">✅ Tasks (<?= count($tasks) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-new-task')">➕ Log Task</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Project Budgets</div>
        <div class="stat-value" style="color: var(--primary);">$<?= number_format($totalBudget, 2) ?></div>
        <div class="stat-desc">Contract value committed</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Active Projects</div>
        <div class="stat-value" style="color: var(--info);"><?= $activeProjects ?></div>
        <div class="stat-desc">Currently in progress</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Open Deliverables</div>
        <div class="stat-value" style="color: var(--warning);"><?= $openTasks ?></div>
        <div class="stat-desc">Assigned tasks pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Completed Tasks</div>
        <div class="stat-value" style="color: var(--success);"><?= $completedTasks ?></div>
        <div class="stat-desc">Closed tickets</div>
    </div>
</div>

<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-projects')">📁 Projects Directory</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-tasks')">✅ Tasks Board</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-project')">➕ New Project</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-task')">➕ Log Task</button>
</div>

<div id="tab-projects" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>Enterprise Projects</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-project')">➕ Add Project</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Client</th>
                    <th>Timeline</th>
                    <th>Budget</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $p): ?>
                    <tr>
                        <td><strong><?= e($p['title']) ?></strong></td>
                        <td><?= e($p['client_name'] ?? 'Internal') ?></td>
                        <td><?= e($p['start_date'] ?? '-') ?> → <?= e($p['end_date'] ?? 'Ongoing') ?></td>
                        <td><strong>$<?= number_format((float)$p['budget'], 2) ?></strong></td>
                        <td>
                            <span class="badge badge-<?= $p['priority'] === 'High' ? 'danger' : 'info' ?>">
                                <?= e($p['priority']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= $p['status'] === 'Completed' ? 'success' : 'primary' ?>">
                                <?= e($p['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-tasks" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Project Tasks & Action Items</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-task')">➕ Log Task</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Task Summary</th>
                    <th>Project</th>
                    <th>Assignee</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $t): ?>
                    <tr>
                        <td><strong><?= e($t['title']) ?></strong></td>
                        <td><?= e($projectMap[$t['project_id']] ?? 'General') ?></td>
                        <td>👤 <?= e($t['assigned_to'] ?? 'Unassigned') ?></td>
                        <td><?= e($t['due_date'] ?? 'No date') ?></td>
                        <td>
                            <span class="badge badge-<?= $t['priority'] === 'High' ? 'danger' : 'info' ?>">
                                <?= e($t['priority']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?= $t['status'] === 'Completed' ? 'success' : ($t['status'] === 'Working' ? 'warning' : 'primary') ?>">
                                <?= e($t['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-new-project" class="erp-tab-pane">
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>Create Project</h3>
        </div>
        <form action="<?= url('/projects/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Project Title *</label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. ERP Cloud Upgrade">
            </div>
            <div class="form-group">
                <label>Client Name / Sponsor</label>
                <input type="text" name="client_name" class="form-control" placeholder="Acme Industrial">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Target End Date</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Estimated Budget ($)</label>
                    <input type="number" step="0.01" name="budget" class="form-control" placeholder="30000">
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <select name="priority" class="form-control">
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Low">Low</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Create Project</button>
        </form>
    </div>
</div>

<div id="tab-new-task" class="erp-tab-pane">
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>Log Action Task</h3>
        </div>
        <form action="<?= url('/projects/tasks/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Task Title *</label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. Database schema migration check">
            </div>
            <div class="form-group">
                <label>Parent Project</label>
                <select name="project_id" class="form-control">
                    <option value="">-- General / Non-Project --</option>
                    <?php foreach ($projects as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= e($p['title']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Assigned To</label>
                    <input type="text" name="assigned_to" class="form-control" placeholder="Team member name">
                </div>
                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" name="due_date" class="form-control" value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority" class="form-control">
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Log Task</button>
        </form>
    </div>
</div>

<script>
function switchErpTab(tabId) {
    document.querySelectorAll('.erp-tab-pane').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.erp-tab-btn').forEach(el => el.classList.remove('active'));
    const pane = document.getElementById(tabId);
    if (pane) pane.classList.add('active');
    const btn = Array.from(document.querySelectorAll('.erp-tab-btn')).find(b => b.getAttribute('onclick')?.includes(tabId));
    if (btn) btn.classList.add('active');
}
</script>
