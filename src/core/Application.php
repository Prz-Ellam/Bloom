<?php

namespace Bloom\core;

use Bloom\Router\Router;
use Closure;

class Application {
    private Router $router;
    private static ?self $instance = null;

    private function __construct() {
        $this->router = new Router();
    }

    public static function app() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run() {
        $uri = $_SERVER["REQUEST_URI"];
        $method = $_SERVER["REQUEST_METHOD"];

        $route = $this->router->resolve($method, $uri);
        $action = $route->getAction();
        $action();
    }

    public function get(string $uri, Closure $action): void {
        $this->router->get($uri, $action);
    }

    public function post(string $uri, Closure $action): void {
        $this->router->post($uri, $action);
    }

    public function put(string $uri, Closure $action): void {
        $this->router->put($uri, $action);
    }

    public function patch(string $uri, Closure $action): void {
        $this->router->patch($uri, $action);
    }

    public function delete(string $uri, Closure $action): void {
        $this->router->delete($uri, $action);
    }

}
