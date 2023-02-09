<?php

namespace Bloom\Tests\Router;

use Bloom\Router\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase {

    public function testBasicRouteCreation() {
        $uri = "/api/v1/users";
        $action = fn() => "test";
        $route = new Route($uri, $action);

        $this->assertEquals($uri, $route->getRouteUri());
        $this->assertEquals($action, $route->getAction());
    }

    public function testMatchUriCorrectly() {
        $uri = "/api/v1/products/:productId/categories/:categoryId/test";
        $action = fn() => "test";
        $route = new Route($uri, $action);

        $desireUris = [
            "/api/v1/products/1/categories/3/test",
            "/api/v1/products/32/categories/21/test",
            "/api/v1/products/a/categories/b/test",
            "/api/v1/products/xxy/categories/wwj/test",
            "/api/v1/products/0/categories/950/test"
        ];

        foreach ($desireUris as $desireUri) {
            $this->assertEquals(true, $route->match($desireUri));
        }

        $desireUrisNotCorrect = [
            "/api/v1/products/categories/3/test",
            "/api/v1/products/32/categories/test",
            "/api/v1/products/categories/test"
        ];

        foreach ($desireUrisNotCorrect as $desireUriNotCorrect) {
            $this->assertEquals(false, $route->match($desireUriNotCorrect));
        }
    }

    public function testParametersReturn() {
        $uri = "/api/v1/users/:userId/products/:productId";
        $action = fn() => "test";
        $route = new Route($uri, $action);

        $desireUri = "/api/v1/users/5/products/9";
        $expectedParameters = [
            "userId" => "5",
            "productId" => "9"
        ];

        $this->assertEquals($expectedParameters, $route->getParameters($desireUri));
    }

}
