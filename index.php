<?php

use Bloom\Application;
use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

require_once "./vendor/autoload.php";

/*
    $input = file_get_contents("php://input");

    [x] GET - urlencoded
    [x] POST - urlencoded
    [x] PUT - urlencoded
    [x] PATCH - urlencoded
    [x] DELETE - urlencoded

    [x] GET - multipart
    [] POST - multipart
    [x] PUT - multipart
    [x] PATCH - multipart
    [x] DELETE - multipart

    [x] GET - raw
    [x] POST - raw
    [x] PUT - raw
    [x] PATCH - raw
    [x] DELETE - raw




    $input = $_POST

    [] GET - urlencoded
    [x] POST - urlencoded
    [] PUT - urlencoded
    [] PATCH - urlencoded
    [] DELETE - urlencoded

    [] GET - multipart
    [x] POST - multipart
    [] PUT - multipart
    [] PATCH - multipart
    [] DELETE - multipart

    [] GET - raw
    [] POST - raw
    [] PUT - raw
    [] PATCH - raw
    [] DELETE - raw




*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$_ENV["VIEW_PATH"] = __DIR__ . '/views';


$app = Application::app(__DIR__);
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

$app->get('/', function(Request $request, $response) {
    $response->json($request->getBody());
});

$app->post('/', function($request, $response) {
    $response->json($request->getBody());
});

$app->put('/', function($request, $response) {
    $response->json($request->getBody());
});



$app->get('/home/:id', function(Request $request, Response $response) { 
    $response->json($request->getParams());
});
$app->get('/about', function(Request $request, Response $response) {
    $session = $request->getSession();
     
    //$session->destroy();
    //$session->set("id", 25);

    $response->render('info');
});

$app->get('/news', [ Middleware1::class, 'handle' ], [ Middleware1::class, Middleware2::class ]);

$app->run();