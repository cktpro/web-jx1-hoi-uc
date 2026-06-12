<?php

class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void {
        $uri = strtok($uri, '?');
        $uri = rtrim($uri, '/') ?: '/';
        // HEAD dùng chung routes GET
        if ($method === 'HEAD') $method = 'GET';

        foreach ($this->routes[$method] ?? [] as $path => $handler) {
            $pattern = preg_replace('#\{[^}]+\}#', '([^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$class, $method] = $handler;
                $controller = new $class();
                $controller->$method(...$matches);
                return;
            }
        }

        http_response_code(404);
        include APP_PATH . '/app/Views/layouts/404.php';
    }
}
