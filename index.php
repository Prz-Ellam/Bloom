<?php

use Bloom\Core\Application;

require_once "./vendor/autoload.php";

class Mock {
    public function index() {
        print("index");
    }
}


$uri = "/api/v1/users/:userId/products/:productId";
$action = fn() => "test";
$route = new Bloom\Router\Route($uri, $action);

$desireUri = "/api/v1/users/5/products/9";
        $expectedParameters = [
            "userId" => "5",
            "productId" => "9"
        ];

var_dump($route->getParameters($desireUri));

$app = Application::app();
// $app->get('/', function($request, $response) { print("Hello Bloom"); });


$app->get('/home/:id', function() { print("Home"); });
$app->get('/about', [ Mock::class, 'index' ]);

$app->run();