<?php

namespace Bloom\Tests\Http;

use Bloom\Http\HttpMethod;
use Bloom\Http\Request\Request;
use PHPUnit\Framework\TestCase;

/**
 * Validar los getters que devuelvan array, string o null
 */

class RequestTest extends TestCase {
    /** @test */
    public function testRequestDataObtainedFromServerReturnsCorrectly() {
        $uri = '/api/v1/users/:id';
        $method = HttpMethod::GET;
        $headers = [
            'Host' => 'localhost:8080',
            'Accept' => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
            'Accept-Language' => "es-MX,es;q=0.8,en-US;q=0.5,en;q=0.3",
            'Accept-Encoding' => "gzip, deflate, br"
        ];
        $query = [ 'id' => '2', 'offset' => '5', 'page' => '9' ];
        $body = [ 'var' => 'a', 'foo' => 'b' ];
        $params = [ 'id' => '9' ];

        $request = new Request();
        $request
            ->setUri($uri)
            ->setMethod($method)
            ->setHeaders($headers)
            ->setQuery($query)
            ->setBody($body)
            ->setParams($params);

        $this->assertEquals($uri, $request->getUri());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($headers, $request->getHeaders());
        $this->assertEquals($query, $request->getQuery());
        $this->assertEquals($body, $request->getBody());
        $this->assertEquals($params, $request->getParams());
    }

}
