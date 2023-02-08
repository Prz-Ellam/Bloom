<?php

namespace Bloom\Middlewares;

use Bloom\Http\Middleware;
use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

class BodyParser implements Middleware {
    public function handle(Request $request, Response $response, Closure $next): void {

    }
}
