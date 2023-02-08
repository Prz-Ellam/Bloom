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

    public abstract function buildUri();
    public abstract function buildMethod();
    public abstract function buildHeaders();
    public abstract function buildQuery();
    public abstract function buildBody();
    public abstract function buildParams();
    public abstract function buildFiles();
}
