<?php

namespace Bloom\Tests;

use Bloom\Http\HttpMethod;
use Bloom\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {
    /** @test */
    public function singleBasicRouting() {
        $uri = "/";
        $method = HttpMethod::GET->value;
        $action = fn() => "test";

        $router = new Router();
        $router->get($uri, $action);

        $route = $router->resolve($method, $uri);
        $this->assertEquals($action, $route->getAction());
    }

    public function multipleBasicRouting() {

    }

    public function multipleBasicRoutingDifferentMethods() {
        
    }
}
