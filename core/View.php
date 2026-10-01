<?php
class View
{
    public static function render(string $view, array $data = [], string $layout = 'app'): string
    {
        extract($data);
        $viewPath = BASE_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: {$viewPath}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout !== '') {
            $layoutPath = BASE_PATH . '/app/Views/layouts/' . $layout . '.php';
            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout file not found: {$layoutPath}");
            }

            $session = new Session();
            $currentUser = $user ?? $session->get('user') ?? [];
            $flashSuccess = $session->getFlash('success');
            $flashError = $error ?? $session->getFlash('error');

            ob_start();
            require $layoutPath;
            return ob_get_clean();
        }

        return $content;
    }
}
