<?php

namespace Bloom\core;

use Bloom\Http\Request\PhpNativeRequestBuilder;
use Bloom\Http\Request\Request;
use Bloom\Http\Request\RequestDirector;
use Bloom\Http\Response\Response;
use Bloom\Router\Router;
use Closure;

/**
 * Kernel of the application
 */
class Application {
    /**
     * HTTP Request structure
     *
     * @var Request
     */
    private Request $request;

    /**
     * HTTP Response structure
     *
     * @var Response
     */
    private Response $response;

    /**
     * Router of the application
     *
     * @var Router
     */
    private Router $router;

    /**
     * Unique instance of the Application
     *
     * @var self|null
     */
    private static ?self $instance = null;

    private function __construct() {
        $this->router = new Router();

        $requestDirector = new RequestDirector();
        $requestDirector->setRequestBuilder(new PhpNativeRequestBuilder());
        $requestDirector->buildRequest();
        $this->request = $requestDirector->getRequest();
        $this->response = new Response();
    }

    public static function app(): self {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Execute the application
     *
     * @return void
     */
    public function run(): void {
        $route = $this->router->resolve($this->request);

        if (!$route) {
            print("404 Not Found");
            http_response_code(404);
            exit();
        }

        $action = $route->getAction();

        if ($action instanceof Closure) {
            $action($this->request, $this->response);
        }
        else if (is_array($action)) {
            $action[0] = new $action[0];
            call_user_func($action, $this->request, $this->response);
        }
    }

    /**
     * Register uri in the main Router for the HTTP Method GET
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
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
