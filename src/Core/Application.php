<?php

namespace Bloom\core;

use Bloom\Http\Request\PhpNativeRequestBuilder;
use Bloom\Http\Request\Request;
use Bloom\Http\Request\RequestDirector;
use Bloom\Http\Response\Response;
use Bloom\Router\Router;
use Closure;

class Application {
    private Request $request;
    private Response $response;
    private Router $router;
    private static ?self $instance = null;

    private function __construct() {
        $this->router = new Router();

        $requestDirector = new RequestDirector();
        $requestDirector->setRequestBuilder(new PhpNativeRequestBuilder());
        $requestDirector->buildRequest();
        $this->request = $requestDirector->getRequest();
        $this->response = new Response();
    }

    public static function app() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run() {
        $route = $this->router->resolve($this->request);
        $action = $route->getAction();

        if ($action instanceof Closure) {
            $action($this->request, $this->response);
        }
        else if (is_array($action)) {
            $action[0] = new $action[0];
            call_user_func($action, $this->request, $this->response);
        }

        

        //call_user_func($action, $this->request, $this->response);
    }

    public function get(string $uri, Closure|array $action): void {
        $this->router->get($uri, $action);
    }

    public function post(string $uri, Closure|array $action): void {
        $this->router->post($uri, $action);
    }

    public function put(string $uri, Closure|array $action): void {
        $this->router->put($uri, $action);
    }

    public function patch(string $uri, Closure|array $action): void {
        $this->router->patch($uri, $action);
    }

    public function delete(string $uri, Closure|array $action): void {
        $this->router->delete($uri, $action);
    }
}
