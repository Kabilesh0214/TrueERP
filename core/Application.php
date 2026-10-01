<?php
class Application
{
    public static Application $app;
    public Router  $router;
    public Request $request;
    public Session $session;

    public function __construct()
    {
        self::$app = $this;

        $config = require BASE_PATH . '/config/app.php';
        date_default_timezone_set($config['timezone'] ?? 'UTC');

        if ($config['debug'] ?? true) {
            ini_set('display_errors', '1');
            error_reporting(E_ALL);
        }

        $this->request = new Request();
        $this->session = new Session();
        $this->router  = new Router($this->request);

        foreach (['auth.php', 'url.php', 'response.php', 'validation.php'] as $h) {
            $f = BASE_PATH . '/app/Helpers/' . $h;
            if (file_exists($f)) {
                require_once $f;
            }
        }
    }

    public function run(): void
    {
        $app = $this;
        require_once BASE_PATH . '/routes/web.php';
        if (file_exists(BASE_PATH . '/routes/api.php')) {
            require_once BASE_PATH . '/routes/api.php';
        }
        echo $this->router->dispatch();
    }
}
