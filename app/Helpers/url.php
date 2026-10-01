<?php
function url(string $path = ''): string
{
    $cleanPath = '/' . ltrim($path, '/');
    if (php_sapi_name() === 'cli-server') {
        return $cleanPath;
    }
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = str_replace('\\', '/', dirname($script));
    $base = ($dir === '/' || $dir === '.' || $dir === '' || $dir === 'erp/public') ? '' : rtrim($dir, '/');
    return $base . $cleanPath;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $url): void
{
    header("Location: " . $url);
    exit;
}

function e(mixed $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
