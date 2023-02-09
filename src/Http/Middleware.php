<?php

namespace Bloom\Http;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;
use Closure;

/**
 * Basic interface for implementing a Middleware
 */
interface Middleware {
    public function handle(Request $request, Response $response, Closure $next);
}
