<?php

namespace Bloom\Tests;

use Bloom\Http\HttpMethod;
use Bloom\Http\Request\Request;
use Bloom\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {
    /** @test */
    public function singleBasicRouting() {
        $uri = "/";
        $method = HttpMethod::GET->value;
        $action = fn() => "test";

        $router = new Router();
        $request = new Request();
        $router->get($uri, $action);

        $route = $router->resolve($request);
        $this->assertEquals($action, $route->getAction());
    }

    public function multipleBasicRouting() {

    }

    public function multipleBasicRoutingDifferentMethods() {
        
    }
}
