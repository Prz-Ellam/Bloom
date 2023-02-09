<?php

use Bloom\Application;

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


$app->get('/home/:id', function() { print("Home"); });
$app->get('/about', function($request, $response) {
    return $response->view("about");
});

$app->run();