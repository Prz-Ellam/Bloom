<?php

namespace Bloom\Router;

use Bloom\Http\HttpMethod;
use Closure;

class Router {
    private array $routes = [];

    public function __construct() {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    public function registerRoute(HttpMethod $method, string $uri, Closure $action): void {
        $this->routes[$method->value][$uri] = new Route($uri, $action); 
    }

    public function get(string $uri, Closure $action): void {
        $this->registerRoute(HttpMethod::GET, $uri, $action);
    }

    public function post(string $uri, Closure $action): void {
        $this->registerRoute(HttpMethod::POST, $uri, $action);
    }

    public function put(string $uri, Closure $action): void {
        $this->registerRoute(HttpMethod::PUT, $uri, $action);
    }

    public function patch(string $uri, Closure $action): void {
        $this->registerRoute(HttpMethod::PATCH, $uri, $action);
    }

    public function delete(string $uri, Closure $action): void {
        $this->registerRoute(HttpMethod::DELETE, $uri, $action);
    }

    public function resolve(string $method, string $uri): ?Route {
        foreach ($this->routes[$method] as $route) {
            if ($route->match($uri)) {
                return $route;
            }
        }
        return null;
    }
}