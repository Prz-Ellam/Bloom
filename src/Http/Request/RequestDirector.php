<?php

namespace Bloom\Http\Request;

class RequestDirector {
    private RequestBuilder $requestBuilder;

    public function setRequestBuilder(RequestBuilder $requestBuilder): void {
        $this->requestBuilder = $requestBuilder;
    }

    public function getRequest(): Request {
        return $this->requestBuilder->getRequest();
    }

    public function buildRequest(): void {
        $this->requestBuilder->buildUri();
        $this->requestBuilder->buildMethod();
        $this->requestBuilder->buildHeaders();
        $this->requestBuilder->buildQuery();
        $this->requestBuilder->buildBody();
        $this->requestBuilder->buildParams();
        $this->requestBuilder->buildFiles();
    }

}
