<?php

namespace Bloom;

use Bloom\Http\Request\PhpNativeRequestBuilder;
use Bloom\Http\Request\Request;
use Bloom\Http\Request\RequestDirector;
use Bloom\Http\Response\Response;
use Bloom\Router\Router;
use Bloom\Templates\TemplateEngine;
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
     * HTML Template for rendering views
     *
     * @var TemplateEngine
     */
    private TemplateEngine $templateEngine;

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

        // TODO: Refactor this
        $this->templateEngine = new TemplateEngine($_ENV["VIEW_PATH"]);
        //$this->templateEngine->setBasePath(dirname(__DIR__, 1) . "/views");
    }

    public static function app(): self {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getTemplateEngine(): TemplateEngine {
        return $this->templateEngine;
    }

    /**
     * Execute the application
     *
     * @return void
     */
    public function run(): void {
        $route = $this->router->resolve($this->request, $this->response);
    }

    /**
     * Register uri in the main Router for the HTTP Method GET
     *
     * @param string $uri
     * @param Closure|array $action
     * @return void
     */
    public function get(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->router->get($uri, $action, $middlewares);
    }

    public function post(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->router->post($uri, $action, $middlewares);
    }

    public function put(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->router->put($uri, $action, $middlewares);
    }

    public function patch(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->router->patch($uri, $action, $middlewares);
    }

    public function delete(string $uri, Closure|array $action, array $middlewares = []): void {
        $this->router->delete($uri, $action, $middlewares);
    }

    public function setNotFound(Closure|array $action) {
        $this->router->setNotFound($action);
    }
}
