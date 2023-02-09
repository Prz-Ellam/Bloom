<?php

namespace Bloom\Http;

use Bloom\Http\Request\Request;
use Bloom\Http\Response\Response;

interface Controller {
    public function show(Request $request, Response $response): ?Response;
}
