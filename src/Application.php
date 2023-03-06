<?php

namespace Bloom;

use Bloom\Database\DatabaseDriver;
use Bloom\Database\PDODatabaseDriver;
use Bloom\Http\Request\PhpNativeRequestBuilder;
use Bloom\Http\Request\Request;
use Bloom\Http\Request\RequestDirector;
use Bloom\Http\Response\Response;
use Bloom\Http\Response\ResponseEmitter;
use Bloom\Router\Router;
use Bloom\Session\PhpNativeSession;
use Bloom\Session\Session;
use Bloom\Templates\TemplateEngine;
use Closure;
use Dotenv\Dotenv;

/**
 * Kernel of the application
 */
class Application {
    private static string $root;

    private Request $request;
    private Response $response;
    private ResponseEmitter $responseEmitter;
    private Session $session;
    private Router $router;
    private TemplateEngine $templateEngine;
    private DatabaseDriver $databaseDriver;

    private static ?self $instance = null;

    private function __construct() {

        $this->loadConfig();

        $this->router = new Router();

        $requestDirector = new RequestDirector();
        $requestDirector->setRequestBuilder(new PhpNativeRequestBuilder());
        $requestDirector->buildRequest();

        $this->session = new PhpNativeSession();
        $this->session->create();
        $this->session->regenerate();
        $this->request = $requestDirector->getRequest();
        $this->request->setSession($this->session);

        $this->response = new Response();
        $this->responseEmitter = new ResponseEmitter();

        $this->templateEngine = new TemplateEngine(self::$root . "/views");

        $this->databaseDriver = new PDODatabaseDriver();
        $this->databaseDriver->connect(
            $_ENV["DATABASE_PROTOCOL"] ?? "", 
            $_ENV["DATABASE_HOST"] ?? "", 
            $_ENV["DATABASE_PORT"] ?? "", 
            $_ENV["DATABASE_USERNAME"] ?? "", 
            $_ENV["DATABASE_PASSWORD"] ?? "", 
            $_ENV["DATABASE_NAME"] ?? ""
        );


    }

    public static function app(string $root = ""): self {
        if (!self::$instance) {
            self::$root = $root;
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function loadConfig() {
        Dotenv::createImmutable(self::$root)->load();
    }

    public function getTemplateEngine(): TemplateEngine {
        return $this->templateEngine;
    }

    public function getDatabaseDriver(): DatabaseDriver {
        return $this->databaseDriver;
    }

    /**
     * Execute the application
     *
     * @return void
     */
    public function run(): void {
        $this->router->resolve($this->request, $this->response);
        $this->responseEmitter->emit($this->response);
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
