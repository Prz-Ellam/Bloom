<?php

namespace Bloom\Http\Request;

use Bloom\Http\HttpMethod;

class PhpNativeRequestBuilder extends RequestBuilder {
    public function buildUri() {
        $this->request->setUri($_SERVER["REQUEST_URI"]);
    }

    public function buildMethod() {
        $this->request->setMethod(HttpMethod::from($_SERVER["REQUEST_METHOD"]));
    }

    public function buildHeaders() {
        $this->request->setHeaders(getallheaders());
    }

    public function buildQuery() {
        $this->request->setQuery($_GET);
    }

    public function buildBody() {
        $this->request->setBody($_POST);
    }

    public function buildParams() {

    }

    public function buildFiles() {
        $this->request->setFiles($_FILES);
    }
}
