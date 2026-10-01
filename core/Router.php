<?php
class Router
{
    private array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path, string|callable $action, array $middleware = []): void
    {
        $this->routes[] = ['method' => 'GET', 'path' => $path, 'action' => $action, 'middleware' => $middleware];
    }

    public function post(string $path, string|callable $action, array $middleware = []): void
    {
        $this->routes[] = ['method' => 'POST', 'path' => $path, 'action' => $action, 'middleware' => $middleware];
    }

    public function dispatch(): string
    {
        $method = $this->request->method();
        $uri    = $this->request->uri();

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                foreach ($route['middleware'] as $middlewareClass) {
                    $mw = new $middlewareClass();
                    $mw->handle();
                }

                if (is_callable($route['action'])) {
                    return (string)call_user_func($route['action']);
                }

                [$controllerClass, $action] = explode('@', $route['action']);
                $controller = new $controllerClass();
                return (string)$controller->$action();
            }
        }

        http_response_code(404);
        return '<h1>404 - Page Not Found</h1><p>The URL <strong>' . htmlspecialchars($uri) . '</strong> was not found on this server.</p><p><a href="' . url('/dashboard') . '">Return to Dashboard</a></p>';
    }
}
