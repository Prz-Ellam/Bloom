<?php

namespace Bloom\Http\Request;

use Bloom\Http\HttpMethod;

/**
 * Concrete implementation of the RequestBuilder for the PHP Development Server
 */
class PhpNativeRequestBuilder extends RequestBuilder {
    /**
     * Construct the uri of the HTTP Request
     *
     * @return void
     */
    public function buildUri(): self {
        $this->request->setUri($_SERVER["REQUEST_URI"]);
        return $this;
    }

    /**
     * Construct the method of the HTTP Request
     *
     * @return void
     */
    public function buildMethod(): self {
        $this->request->setMethod(HttpMethod::from($_SERVER["REQUEST_METHOD"]));
        return $this;
    }

    public function buildHeaders(): self {
        $this->request->setHeaders(getallheaders());
        return $this;
    }

    public function buildQuery(): self {
        $this->request->setQuery($_GET);
        return $this;
    }

    public function buildBody(): self {
        $this->request->setBody($_POST);
        return $this;
    }

    public function buildParams(): self {
        return $this;
    }

    public function buildFiles(): self {
        $this->request->setFiles($_FILES);
        return $this;
    }
}
