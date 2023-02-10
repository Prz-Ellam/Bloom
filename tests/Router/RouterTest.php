<?php

namespace Bloom\Tests;

use Bloom\Http\HttpMethod;
use Bloom\Http\Request\Request;
use Bloom\Router\Router;
use PHPUnit\Framework\TestCase;

/**
 * TODO:
 * - Validar el formato del action acepte tanto array como Closure
 * 
 */

class RouterTest extends TestCase {
    /** @test */
    public function testSingleBasicRouting() {
        $uri = "/";
        $method = HttpMethod::GET;
        $action = fn() => "test";

        $router = new Router();
        $request = new Request();
        $request
            ->setUri($uri)
            ->setMethod($method);

        $router->get($uri, $action);
        $route = $router->resolveRoute($request);
        $this->assertEquals($action, $route->getAction());
    }

    public function testMultipleBasicRouting() {
        $routes = [
            "/" => fn() => "test1",
            "/home" => fn() => "test2",
            "/about" => fn() => "test3",
            "/contacts" => fn() => "test4",
            "/api/users" => fn() => "test5"
        ];
        $method = HttpMethod::GET;

        $router = new Router();
        foreach ($routes as $uri => $action) {
            match ($method) {
                HttpMethod::GET => $router->get($uri, $action),
                HttpMethod::POST => $router->post($uri, $action),
                HttpMethod::PUT => $router->put($uri, $action),
                HttpMethod::PATCH => $router->patch($uri, $action),
                HttpMethod::DELETE => $router->delete($uri, $action),
            };
        }

        foreach ($routes as $uri => $action) {
            $request = new Request();
            $request
                ->setUri($uri)
                ->setMethod($method);

            $route = $router->resolveRoute($request);
            $this->assertEquals($uri, $route->getRouteUri());
            $this->assertEquals($action, $route->getAction());
        }
    }

    public function testMultipleBasicRoutingDifferentMethods() {
        $routes = [
            [ HttpMethod::GET, "/", fn() => "test1" ],
            [ HttpMethod::POST, "/home", fn() => "test2" ],
            [ HttpMethod::PUT, "/about", fn() => "test3" ],
            [ HttpMethod::PATCH, "/contacts", fn() => "test4" ],
            [ HttpMethod::DELETE, "/api/users", fn() => "test5" ],
            [ HttpMethod::PUT, "/api/products", fn() => "test5" ]
        ];

        $router = new Router();
        foreach ($routes as $route) {
            [ $method, $uri, $action ] = $route;
            match ($method) {
                HttpMethod::GET => $router->get($uri, $action),
                HttpMethod::POST => $router->post($uri, $action),
                HttpMethod::PUT => $router->put($uri, $action),
                HttpMethod::PATCH => $router->patch($uri, $action),
                HttpMethod::DELETE => $router->delete($uri, $action),
            };
        }

        foreach ($routes as $route) {
            [ $method, $uri, $action ] = $route;
            $request = new Request();
            $request
                ->setUri($uri)
                ->setMethod($method);

            $route = $router->resolveRoute($request);
            $this->assertEquals($uri, $route->getRouteUri());
            $this->assertEquals($action, $route->getAction());
        }
    }

    public function testRouteParameters() {
        $routeParams = [
            [ HttpMethod::DELETE, "/api/users/:id", fn() => "test1" ],
            [ HttpMethod::PUT, "/api/products/:id", fn() => "test2" ],
            [ HttpMethod::POST, "/api/users/:userId/messages/:messageId", fn() => "test3" ]
        ];

        $routes = [
            [ HttpMethod::DELETE, "/api/users/3" ],
            [ HttpMethod::PUT, "/api/products/1" ],
            [ HttpMethod::PUT, "/api/products/95" ],
            [ HttpMethod::POST, "/api/users/3/messages/5" ]
        ];

        $router = new Router();
        foreach ($routeParams as $route) {
            [ $method, $uri, $action ] = $route;
            match ($method) {
                HttpMethod::GET => $router->get($uri, $action),
                HttpMethod::POST => $router->post($uri, $action),
                HttpMethod::PUT => $router->put($uri, $action),
                HttpMethod::PATCH => $router->patch($uri, $action),
                HttpMethod::DELETE => $router->delete($uri, $action),
            };
        }

        foreach ($routes as $route) {
            [ $method, $uri ] = $route;
            $request = new Request();
            $request
                ->setUri($uri)
                ->setMethod($method);

            $route = $router->resolveRoute($request);
            $this->assertNotNull($route);
            $this->assertEquals($action, $route->getAction());
        }
    }
}
