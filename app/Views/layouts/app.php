<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP ERP - Enterprise Management</title>
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>
<body>

<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="app-wrapper">
    <?php require BASE_PATH . '/app/Views/layouts/sidebar.php'; ?>

    <main class="main-container">
        <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success">
                <span>✓</span>
                <div><?= e($flashSuccess) ?></div>
            </div>
        <?php endif; ?>

        <?php if (!empty($flashError)): ?>
            <div class="alert alert-error">
                <span>⚠</span>
                <div><?= e($flashError) ?></div>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>
</div>

<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>

</body>
</html>
