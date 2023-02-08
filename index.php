<?php

use Bloom\Core\Application;

require_once "./vendor/autoload.php";

$app = Application::app();
$app->get('/', function($request, $response) {
    print("Hello Bloom");
});
$app->get('/home', function() {
    print("Home");
});

$app->run();