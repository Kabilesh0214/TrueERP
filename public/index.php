<?php
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($path !== '/' && file_exists(__DIR__ . $path)) {
        return false;
    }
}

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(function (string $class) {
    $directories = [
        BASE_PATH . '/core/',
        BASE_PATH . '/app/Controllers/',
        BASE_PATH . '/app/Models/',
        BASE_PATH . '/app/Services/',
        BASE_PATH . '/app/Middleware/',
    ];

    foreach ($directories as $dir) {
        $file = $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$app = new Application();
$app->run();
