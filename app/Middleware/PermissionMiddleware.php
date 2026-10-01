<?php
class PermissionMiddleware
{
    public function handle(): void
    {
        $session = new Session();
        $user = $session->get('user');
        if (!$user) {
            header('Location: ' . url('/login'));
            exit;
        }

        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        if (str_contains($uri, '/users') && ($user['role'] ?? '') !== 'admin') {
            $session->flash('error', 'Access denied. Administrator privileges required.');
            header('Location: ' . url('/dashboard'));
            exit;
        }
    }
}
