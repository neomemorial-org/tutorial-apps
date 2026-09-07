<?php
declare(strict_types=1);

namespace App\Core;

// Router minimo: mapea metodo + path a [Controlador, accion].
final class Router
{
    /** @var array<string, array<string, array{class-string, string}>> */
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = rtrim($path, '/') ?: '/';

        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            echo '404 - Not Found';
            return;
        }

        [$class, $action] = $handler;
        (new $class())->{$action}();
    }
}
