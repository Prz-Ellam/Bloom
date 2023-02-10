<?php

namespace Bloom\Http;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

abstract class Controller {
    protected array $middlewares = [];
    public abstract function show(Request $request, Response $response): mixed;
}
