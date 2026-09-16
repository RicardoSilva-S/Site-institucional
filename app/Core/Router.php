<?php

namespace App\Core;

/**
 * Router — registra rotas e despacha para o controller certo.
 * Suporta parâmetros dinâmicos: /noticias/{slug}
 */
class Router
{
    private array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $pattern, $action): void
    {
        $this->routes[] = ['method' => 'GET', 'pattern' => $pattern, 'action' => $action];
    }

    public function post(string $pattern, $action): void
    {
        $this->routes[] = ['method' => 'POST', 'pattern' => $pattern, 'action' => $action];
    }

    public function dispatch(): void
    {
        $uri    = $this->request->uri();
        $method = $this->request->method();

        // Remove o prefixo da pasta se o projeto não estiver na raiz do servidor
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        if ($base && strpos($uri, $base) === 0) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = [];
            $regex  = $this->toRegex($route['pattern'], $params);

            if (preg_match($regex, $uri, $matches)) {
                // Pega só os grupos nomeados
                $args = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->resolve($route['action'], array_values($args));
                return;
            }
        }

        // Nenhuma rota encontrada
        http_response_code(404);
        require __DIR__ . '/../Views/404.php';
    }

    /** Converte /noticias/{slug} em regex nomeada */
    private function toRegex(string $pattern, array &$params): string
    {
        $regex = preg_replace_callback('/\{(\w+)\}/', function ($m) use (&$params) {
            $params[] = $m[1];
            return '(?P<' . $m[1] . '>[^/]+)';
        }, $pattern);

        return '#^' . $regex . '$#';
    }

    /** Chama o controller/método ou closure */
    private function resolve($action, array $args = []): void
    {
        if (is_callable($action)) {
            call_user_func_array($action, $args);
            return;
        }

        // Formato: [HomeController::class, 'index']  ou  'HomeController@index'
        if (is_array($action)) {
            [$class, $method] = $action;
        } else {
            [$class, $method] = explode('@', $action);
        }

        if (!class_exists($class)) {
            die("Controller não encontrado: {$class}");
        }

        $controller = new $class();
        call_user_func_array([$controller, $method], $args);
    }
}
