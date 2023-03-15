<?php

namespace Bloom\Router;

use Bloom\Http\Exceptions\HttpNotFoundException;
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
    protected array $routes = [];
    private Closure|array|null $notFound = null;

    /**
     * Initialize all HTTP Methods in $routes array
     */
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
    public function registerRoute(HttpMethod $method, string $uri, Closure|array $action, array $middlewares = []): void {
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
     * Find the route of a HTTP Request
     *
     * @param Request $request
     * @return ?Route
     */
    public function resolveRoute(Request $request): ?Route {
        $method = $request->getMethod();
        $uri = $request->getUri();
        foreach ($this->routes[$method->value] as $route) {
            if ($route->match($uri)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Execute the route action
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function resolve(Request $request, Response $response): void {
        $route = $this->resolveRoute($request);

        if (!$route) {
            call_user_func($this->notFound, $request, $response);
            return;
            //throw new HttpNotFoundException();
        }

        // Weird
        $request->setParams($route->getParameters($request->getUri()));

        $middlewares = $route->getMiddlewares();
        $action = $route->getAction();

        $this->runMiddlewares($request, $response, $middlewares, $action);
    }

    /**
     * Execute the register middlewares and the action of a Route
     *
     * @param Request $request
     * @param Response $response
     * @param array $middlewares
     * @param Closure|array $target
     * @return void
     */
    public function runMiddlewares(Request $request, Response $response, array $middlewares, Closure|array $target) {
        if (count($middlewares) == 0) {
            if ($target instanceof Closure) {
                $target($request, $response);
            }
            else if (is_array($target)) {
                $target[0] = new $target[0];
                call_user_func($target, $request, $response);
            }
            return;
        }
        $middleware = new $middlewares[0][0];
        return $middleware->handle(
            $request, 
            $response, 
            fn() => $this->runMiddlewares($request, $response, array_slice($middlewares, 1), $target),
            array_slice($middlewares[0], 1)
        );
    }

    public function setNotFound(Closure|array $action) {
        $this->notFound = $action;
    }
}