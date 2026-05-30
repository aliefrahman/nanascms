<?php

namespace Core;

class Router {
    protected array $routes = [];
    protected ?string $lastMethod = null;
    protected ?string $lastPath = null;

    public function get(string $path, $handler): self {
        $this->routes['GET'][$path] = [
            'handler' => $handler,
            'middlewares' => []
        ];
        $this->lastMethod = 'GET';
        $this->lastPath = $path;
        return $this;
    }

    public function post(string $path, $handler): self {
        $this->routes['POST'][$path] = [
            'handler' => $handler,
            'middlewares' => []
        ];
        $this->lastMethod = 'POST';
        $this->lastPath = $path;
        return $this;
    }

    public function middleware(array $middlewares): self {
        if ($this->lastMethod && $this->lastPath) {
            $this->routes[$this->lastMethod][$this->lastPath]['middlewares'] = array_merge(
                $this->routes[$this->lastMethod][$this->lastPath]['middlewares'],
                $middlewares
            );
        }
        return $this;
    }

    public function resolve(): void {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        // Normalize base path if running in a subdirectory (e.g. /nanascms/public)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = dirname($scriptName);
        if ($basePath !== '/' && $basePath !== '\\') {
            if (strpos($uri, $basePath) === 0) {
                $uri = substr($uri, strlen($basePath));
            }
        }

        // Normalize URI: strip trailing slashes, keep '/' as is
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }
        
        if ($uri === '') {
            $uri = '/';
        }

        $route = $this->routes[$method][$uri] ?? null;

        if (!$route) {
            http_response_code(404);
            // Render a beautiful 404 page or simple message
            echo "404 Not Found";
            return;
        }

        // Support both old raw handlers and new route configurations
        $handler = is_array($route) && isset($route['handler']) ? $route['handler'] : $route;
        $middlewares = is_array($route) && isset($route['middlewares']) ? $route['middlewares'] : [];

        // Run middlewares sequentially
        foreach ($middlewares as $middlewareClass) {
            if (class_exists($middlewareClass)) {
                $middleware = new $middlewareClass();
                if (method_exists($middleware, 'handle')) {
                    $middleware->handle();
                }
            }
        }

        if (is_callable($handler)) {
            call_user_func($handler);
            return;
        }

        if (is_array($handler)) {
            [$controllerClass, $methodName] = $handler;
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                    return;
                }
            }
        }

        http_response_code(500);
        echo "500 Internal Server Error: Invalid handler configuration.";
    }
}
