<?php

namespace Bloom\Http\Response;

class ResponseEmitter {
    public function __construct() {
        
    }

    public function emit(Response $response) {
        http_response_code($response->getStatus()->value);
        foreach ($response->getHeaders() as $key => $value)
        {
            header("$key: $value");
        }
        header("Content-Length: " . strlen($response->getBody()));
        print($response->getBody());
    }
}
