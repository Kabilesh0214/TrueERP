<?php
class Request
{
    public function method(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    {
        $raw = $_SERVER['REQUEST_URI'] ?? '/';
        $uri = parse_url($raw, PHP_URL_PATH) ?? '/';

        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
        if ($scriptDir !== '' && $scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        $uri = rtrim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        $val = $_POST[$key] ?? $default;
        return is_string($val) ? htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8') : $val;
    }

    public function all(): array
    {
        return $_POST;
    }
}
