<?php

namespace App\;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match

                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$controller, $methodName] = $handler;
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $methodName], $matches);
                } else {
                    call_user_func_array($handler, $matches);
                }
                return;
            }
        }

        // 404
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
