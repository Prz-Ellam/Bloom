<?php

namespace Bloom\Http\Request;

abstract class RequestBuilder {
    protected Request $request;

    public function __construct() {
        $this->request = new Request();
    }

    public function getRequest(): Request {
        return $this->request;
    }

    public abstract function buildUri(): self;
    public abstract function buildMethod(): self;
    public abstract function buildHeaders(): self;
    public abstract function buildQuery(): self;
    public abstract function buildBody(): self;
    public abstract function buildParams(): self;
    public abstract function buildFiles(): self;
    public abstract function buildProtocol(): self;
}
