<?php

namespace Bloom\Router;

use Bloom\Http\HttpMethod;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class Router {
    /**
     * Collection of the register routes for group by HTTP Method
     *
     * @var array<HttpMethod, Route>
     */
    private array $routes = [];

    public function __construct() {
        foreach (HttpMethod::cases() as $method) {
            $this->routes[$method->value] = [];
        }
    }

    /**
     * Include a new route in the collection of routes
     *
     * @param HttpMethod $method
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function registerRoute(HttpMethod $method, string $uri, Closure|array $action): void {
        $middlewares = [];
        $this->routes[$method->value][$uri] = new Route($uri, $action, $middlewares); 
    }

    public function get(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->registerRoute(HttpMethod::GET, $uri, $action, $middlewares);
    }

    public function post(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->registerRoute(HttpMethod::POST, $uri, $action, $middlewares);
    }

    public function put(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->registerRoute(HttpMethod::PUT, $uri, $action, $middlewares);
    }

    public function patch(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->registerRoute(HttpMethod::PATCH, $uri, $action, $middlewares);
    }

    public function delete(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->registerRoute(HttpMethod::DELETE, $uri, $action, $middlewares);
    }

    /**
     * Find the action of a HTTP Request
     *
     * @param Request $request
     * @return ?Route
     */
    public function resolve(Request $request): ?Route {
        $method = $request->getMethod();
        $uri = $request->getUri();
        foreach ($this->routes[$method->value] as $route) {
            if ($route->match($uri)) {
                return $route;
            }
        }
        return null;
    }

    public function resolve2(Request $request, Response $response) {
        $route = $this->resolve($request);
        $action = $route->getAction();
        $middlewares = $route->getMiddlewares();

        if ($action instanceof Closure) {
            $action($request, $response);
        }
        else if (is_array($action)) {
            $action[0] = new $action[0];
            call_user_func($action, $request, $response);
        }
    }

    public function runMiddlewares(Request $request, Response $response, array $middlewares, Closure|array $target) {
        if (count($middlewares) == 0) {
            return $target($request, $response);
        }
        return $middlewares[0]->handle(
            $request, 
            $response, 
            fn() => $this->runMiddlewares($request, $response, array_slice($middlewares, 1), $target));
    }
}