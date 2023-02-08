<?php

use Bloom\Core\Application;

require_once "./vendor/autoload.php";

class Mock {
    public function index() {
        print("index");
    }
}


$app = Application::app();
// $app->get('/', function($request, $response) { print("Hello Bloom"); });

$app->get('/home', function() { print("Home"); });
$app->get('/about', [ Mock::class, 'index' ]);

$app->run();