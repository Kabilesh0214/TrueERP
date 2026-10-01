<?php
class AuthService
{
    private User $userModel;
    private Session $session;

    public function __construct()
    {
        $this->userModel = new User();
        $this->session   = new Session();
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user || $user['status'] !== 'active') {
            return false;
        }

        if (password_verify($password, $user['password']) || $user['password'] === $password) {
            unset($user['password']);
            $this->session->set('user', $user);
            Logger::info("User logged in", ['email' => $email]);
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        $this->session->destroy();
    }
}
