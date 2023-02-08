<?php

use Bloom\core\Application;

require_once "./vendor/autoload.php";

$app = Application::app();
$app->get('/', function() {
    print("Hello Bloom");
});
$app->get('/home', function() {
    print("Home");
});

$app->run();