<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">👥</div>
        <div>
            <h1>Human Resources & Payroll</h1>
            <p>Employees, Attendance, Department Headcounts, and Staffing</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" onclick="switchErpTab('tab-new-emp')">➕ Onboard Employee</button>
        <button class="btn btn-secondary" onclick="switchErpTab('tab-mark-att')">📅 Mark Attendance</button>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-employees')">👥 Employees (<?= count($employees) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-attendance')">📅 Today's Attendance (<?= $presentCount ?> Present)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-depts')">🏢 Departments</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-new-emp')">➕ Add Employee</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Active Staff</div>
        <div class="stat-value" style="color: var(--primary);"><?= $activeCount ?></div>
        <div class="stat-desc">Full-time employees</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Present Today</div>
        <div class="stat-value" style="color: var(--success);"><?= $presentCount ?> / <?= count($employees) ?></div>
        <div class="stat-desc">Attendance logged</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Annualized Payroll</div>
        <div class="stat-value" style="color: var(--info);">$<?= number_format($totalPayroll, 2) ?></div>
        <div class="stat-desc">Total base compensation</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Departments</div>
        <div class="stat-value"><?= count($deptCounts) ?></div>
        <div class="stat-desc">Operating business units</div>
    </div>
</div>

<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-employees')">👥 Employee Directory</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-attendance')">📅 Attendance Log</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-depts')">🏢 Departments</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-emp')">➕ Onboard Employee</button>
</div>

<div id="tab-employees" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>Staff Roster</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-emp')">➕ Add Employee</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Emp Code</th>
                    <th>Full Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $emp): ?>
                    <tr>
                        <td><code><?= e($emp['employee_code']) ?></code></td>
                        <td>
                            <strong><?= e($emp['full_name']) ?></strong>
                            <div style="font-size:0.8rem; color:var(--text-muted);"><?= e($emp['email'] ?? '') ?></div>
                        </td>
                        <td><span class="badge badge-info"><?= e($emp['department']) ?></span></td>
                        <td><?= e($emp['designation']) ?></td>
                        <td><strong>$<?= number_format((float)$emp['salary'], 2) ?></strong></td>
                        <td><span class="badge badge-success"><?= e($emp['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-attendance" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Attendance Log</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-mark-att')">📅 Check In Staff</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Employee ID</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendances as $att): ?>
                    <tr>
                        <td>#<?= $att['id'] ?></td>
                        <td>Emp ID: <?= e($att['employee_id']) ?></td>
                        <td><?= e($att['date']) ?></td>
                        <td>
                            <span class="badge badge-<?= $att['status'] === 'Present' ? 'success' : 'warning' ?>">
                                <?= e($att['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-depts" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Department Breakdown</h3>
        </div>
        <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
            <?php foreach ($deptCounts as $dept => $cnt): ?>
                <div style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 1.25rem; background: #ffffff;">
                    <div style="font-size:0.8rem; color:var(--text-muted); text-transform:uppercase; font-weight:700;">Department</div>
                    <h3 style="margin: 0.25rem 0;"><?= e($dept) ?></h3>
                    <div style="font-size:0.9rem; color:var(--primary); font-weight:600;"><?= $cnt ?> Team Member(s)</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div id="tab-new-emp" class="erp-tab-pane">
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>Onboard New Employee</h3>
        </div>
        <form action="<?= url('/hr/employees/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Full Legal Name *</label>
                <input type="text" name="full_name" class="form-control" required placeholder="Jane Doe">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required placeholder="jane@erp.com">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="+1-555-0199">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Department</label>
                    <select name="department" class="form-control">
                        <option value="Engineering">Engineering</option>
                        <option value="Operations">Operations & Logistics</option>
                        <option value="Sales">Sales & Business Dev</option>
                        <option value="Human Resources">Human Resources</option>
                        <option value="Finance">Finance & Accounting</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Designation / Job Title</label>
                    <input type="text" name="designation" class="form-control" placeholder="Software Engineer">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Joining Date</label>
                    <input type="date" name="joining_date" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Annual Salary ($)</label>
                    <input type="number" step="1000" name="salary" class="form-control" value="65000">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Onboard Employee</button>
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
