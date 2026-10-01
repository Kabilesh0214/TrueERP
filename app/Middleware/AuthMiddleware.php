<?php
class AuthMiddleware
{
    public function handle(): void
    {
        $session = new Session();
        if (!$session->has('user')) {
            $session->flash('error', 'Please log in to access this page.');
            header('Location: ' . url('/login'));
            exit;
        }
    }
}
