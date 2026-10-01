<div class="erp-workspace-header">
    <div class="erp-workspace-title">
        <div class="erp-icon-badge">🎯</div>
        <div>
            <h1>CRM & Sales Pipeline</h1>
            <p>Leads, Opportunities, Sales Funnel, and Customer Conversions</p>
        </div>
    </div>
    <div class="header-actions">
        <button class="btn btn-primary" onclick="switchErpTab('tab-new-lead')">➕ New Lead</button>
        <a href="<?= url('/customers/create') ?>" class="btn btn-secondary">➕ New Customer</a>
    </div>
</div>

<div class="erp-shortcuts-bar">
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-leads')">🎯 Leads (<?= count($leads) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-kanban')">🚀 Opportunity Pipeline</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-crm-customers')">🤝 Customers (<?= count($customers) ?>)</span>
    <span class="erp-shortcut-chip" onclick="switchErpTab('tab-new-lead')">➕ Add Lead</span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Pipeline Value</div>
        <div class="stat-value" style="color: var(--primary);">$<?= number_format($pipelineValue, 2) ?></div>
        <div class="stat-desc">Potential deal volume</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Active Opportunities</div>
        <div class="stat-value" style="color: var(--warning);"><?= $oppCount ?></div>
        <div class="stat-desc">High-intent stages</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Converted Clients</div>
        <div class="stat-value" style="color: var(--success);"><?= $convertedCount ?></div>
        <div class="stat-desc">Won contracts</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Leads Logged</div>
        <div class="stat-value"><?= count($leads) ?></div>
        <div class="stat-desc">Across all acquisition channels</div>
    </div>
</div>

<div class="erp-tabs-nav">
    <button class="erp-tab-btn active" onclick="switchErpTab('tab-leads')">🎯 Leads Directory</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-kanban')">🚀 Pipeline Board</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-crm-customers')">🤝 Converted Customers</button>
    <button class="erp-tab-btn" onclick="switchErpTab('tab-new-lead')">➕ Capture Lead</button>
</div>

<div id="tab-leads" class="erp-tab-pane active">
    <div class="card">
        <div class="card-header">
            <h3>All CRM Leads</h3>
            <button class="btn btn-primary btn-sm" onclick="switchErpTab('tab-new-lead')">➕ Add Lead</button>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Lead Name</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Est. Value</th>
                    <th>Source</th>
                    <th>Stage</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td><strong><?= e($lead['name']) ?></strong></td>
                        <td><?= e($lead['company'] ?? '-') ?></td>
                        <td>
                            <div><?= e($lead['email'] ?? '-') ?></div>
                            <small class="text-muted"><?= e($lead['phone'] ?? '') ?></small>
                        </td>
                        <td><strong>$<?= number_format((float)$lead['estimated_value'], 2) ?></strong></td>
                        <td><span class="badge badge-info"><?= e($lead['source'] ?? 'Website') ?></span></td>
                        <td>
                            <form action="<?= url('/crm/leads/status') ?>" method="POST" style="display:inline-flex; align-items:center; gap:0.25rem;">
                                <input type="hidden" name="id" value="<?= $lead['id'] ?>">
                                <select name="status" onchange="this.form.submit()" style="font-size:0.75rem; padding:0.2rem 0.4rem; border-radius:4px; border:1px solid var(--border-color);">
                                    <?php foreach (['Lead', 'Open', 'Replied', 'Opportunity', 'Converted', 'Lost'] as $st): ?>
                                        <option value="<?= $st ?>" <?= ($lead['status'] ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                        <td>
                            <?php if (($lead['status'] ?? '') !== 'Converted'): ?>
                                <a href="<?= url('/customers/create?name=' . urlencode($lead['name']) . '&company=' . urlencode($lead['company'] ?? '') . '&email=' . urlencode($lead['email'] ?? '')) ?>" class="btn btn-secondary btn-sm">Convert</a>
                            <?php else: ?>
                                <span class="badge badge-success">Won</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-kanban" class="erp-tab-pane">
    <div class="pipeline-grid">
        <div class="pipeline-col">
            <div class="pipeline-col-header">
                <span>🌱 New Leads</span>
            </div>
            <?php foreach ($leads as $l): if (($l['status'] ?? 'Lead') === 'Lead'): ?>
                <div class="pipeline-card">
                    <h4><?= e($l['name']) ?></h4>
                    <p><?= e($l['company'] ?? 'Private') ?></p>
                    <div style="font-weight:700; color:var(--primary);">$<?= number_format((float)$l['estimated_value'], 2) ?></div>
                </div>
            <?php endif; endforeach; ?>
        </div>
        <div class="pipeline-col">
            <div class="pipeline-col-header">
                <span>💬 Open / Contacted</span>
            </div>
            <?php foreach ($leads as $l): if (in_array($l['status'] ?? '', ['Open', 'Replied'])): ?>
                <div class="pipeline-card">
                    <h4><?= e($l['name']) ?></h4>
                    <p><?= e($l['company'] ?? 'Private') ?></p>
                    <div style="font-weight:700; color:var(--warning);">$<?= number_format((float)$l['estimated_value'], 2) ?></div>
                </div>
            <?php endif; endforeach; ?>
        </div>
        <div class="pipeline-col">
            <div class="pipeline-col-header">
                <span>🔥 Opportunities</span>
            </div>
            <?php foreach ($leads as $l): if (($l['status'] ?? '') === 'Opportunity'): ?>
                <div class="pipeline-card">
                    <h4><?= e($l['name']) ?></h4>
                    <p><?= e($l['company'] ?? 'Private') ?></p>
                    <div style="font-weight:700; color:var(--info);">$<?= number_format((float)$l['estimated_value'], 2) ?></div>
                </div>
            <?php endif; endforeach; ?>
        </div>
        <div class="pipeline-col">
            <div class="pipeline-col-header">
                <span>🏆 Converted / Won</span>
            </div>
            <?php foreach ($leads as $l): if (($l['status'] ?? '') === 'Converted'): ?>
                <div class="pipeline-card" style="border-left: 3px solid var(--success);">
                    <h4><?= e($l['name']) ?></h4>
                    <p><?= e($l['company'] ?? 'Private') ?></p>
                    <div style="font-weight:700; color:var(--success);">$<?= number_format((float)$l['estimated_value'], 2) ?></div>
                </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
</div>

<div id="tab-crm-customers" class="erp-tab-pane">
    <div class="card">
        <div class="card-header">
            <h3>Active Customer Accounts</h3>
            <a href="<?= url('/customers/create') ?>" class="btn btn-primary btn-sm">➕ Add Customer</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $c): ?>
                    <tr>
                        <td><strong><?= e($c['name']) ?></strong></td>
                        <td><?= e($c['company'] ?? '-') ?></td>
                        <td><?= e($c['email'] ?? '-') ?></td>
                        <td><?= e($c['phone'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="tab-new-lead" class="erp-tab-pane">
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>Capture New Lead</h3>
        </div>
        <form action="<?= url('/crm/leads/store') ?>" method="POST" style="padding: 1.5rem;">
            <div class="form-group">
                <label>Prospect Full Name *</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" required>
            </div>
            <div class="form-group">
                <label>Company / Organization</label>
                <input type="text" name="company" class="form-control" placeholder="Acme Inc">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="prospect@company.com">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="+1-555-0199">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Estimated Deal Value ($)</label>
                    <input type="number" step="0.01" name="estimated_value" class="form-control" placeholder="15000">
                </div>
                <div class="form-group">
                    <label>Lead Source</label>
                    <select name="source" class="form-control">
                        <option value="Website">Website Form</option>
                        <option value="Referral">Customer Referral</option>
                        <option value="Conference">Industry Conference</option>
                        <option value="Cold Outreach">Cold Outreach / LinkedIn</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Lead to CRM</button>
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
