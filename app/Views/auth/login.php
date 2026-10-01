<div class="auth-card">
    <div class="auth-header">
        <div class="logo-badge">ERP</div>
        <h1>Welcome to PHP ERP</h1>
        <p>Sign in to access your business workspace</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error">
            <span>⚠</span>
            <div><?= e($error) ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            <span>✓</span>
            <div><?= e($success) ?></div>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= url('/login') ?>">
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="admin@erp.com" required autofocus placeholder="name@company.com">
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" value="admin123" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary btn-full" style="padding: 0.75rem;">Sign In to Dashboard →</button>
    </form>

    <div class="auth-demo-box">
        <strong>Demo Credentials:</strong><br>
        • Admin: <code>admin@erp.com</code> / <code>admin123</code><br>
        • Staff: <code>staff@erp.com</code> / <code>staff123</code>
    </div>
</div>
