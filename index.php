<?php

use Bloom\Application;
use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

require_once "./vendor/autoload.php";

class Mock {
    public function index() {
        print("index");
    }
}


$uri = "/api/v1/users/:userId/products/:productId";
$action = fn() => "test";
$route = new Bloom\Router\Route($uri, $action);

$app = Application::app();
// $app->get('/', function($request, $response) { print("Hello Bloom"); });

class Middleware1 implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        print("Hola 1");
        $next();
    }
}

class Middleware2 implements Middleware {
    public function handle(Request $request, Response $response, Closure $next) {
        print("Hola 2");
        $next();
    }
}

$app->get('/home/:id', function() { print("Home"); });
$app->get('/about', function($request, $response) {
    $response->render('about', [ "app" => "Bloom" ]);
});

$app->get('/news', [ Middleware1::class, 'show' ], [ Middleware1::class, Middleware2::class ]);

$app->run();