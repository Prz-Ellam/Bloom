<?php

namespace Bloom\Http\Request;

class RequestDirector {
    private ?RequestBuilder $requestBuilder = null;

    public function setRequestBuilder(RequestBuilder $requestBuilder): void {
        $this->requestBuilder = $requestBuilder;
    }

    public function getRequest(): Request {
        return $this->requestBuilder->getRequest();
    }

    public function buildRequest(): void {
        if (!$this->requestBuilder) {
            return;
        }
        
        $this->requestBuilder
            ->buildUri()
            ->buildMethod()
            ->buildHeaders()
            ->buildQuery()
            ->buildBody()
            ->buildParams()
            ->buildFiles();
    }

}
