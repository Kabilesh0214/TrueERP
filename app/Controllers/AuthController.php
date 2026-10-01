<?php
class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    public function showLogin(): string
    {
        if ($this->session->has('user')) {
            return $this->redirect(url('/dashboard'));
        }
        $error = $this->session->getFlash('error');
        $success = $this->session->getFlash('success');
        return $this->view('auth.login', ['error' => $error, 'success' => $success], 'auth');
    }

    public function login(): string
    {
        $email    = $this->request->post('email');
        $password = $this->request->post('password');

        if (empty($email) || empty($password)) {
            $this->session->flash('error', 'Please enter both email and password.');
            return $this->redirect(url('/login'));
        }

        if ($this->authService->attempt($email, $password)) {
            $this->session->flash('success', 'Logged in successfully.');
            return $this->redirect(url('/dashboard'));
        }

        $this->session->flash('error', 'Invalid email address or password.');
        return $this->redirect(url('/login'));
    }

    public function logout(): string
    {
        $this->authService->logout();
        $this->session->flash('success', 'You have been logged out.');
        return $this->redirect(url('/login'));
    }
}
