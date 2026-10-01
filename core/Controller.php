<?php
class Controller
{
    protected Session $session;
    protected Request $request;

    public function __construct()
    {
        $this->session = new Session();
        $this->request = new Request();
    }

    protected function view(string $view, array $data = [], string $layout = 'app'): string
    {
        return View::render($view, $data, $layout);
    }

    protected function redirect(string $url): string
    {
        header('Location: ' . $url);
        exit;
    }
}
