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
        $this->request->setUri(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
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
        $this->request->setBody($this->getPostData());
        return $this;
    }

    public function buildParams(): self {
        return $this;
    }

    public function buildFiles(): self {
        $this->request->setFiles($_FILES);
        return $this;
    }

    public function buildProtocol(): self {
        $_SERVER["SERVER_PROTOCOL"];
        return $this;
    }

    private function getPostData(): array {
        
        $requestsTable = [
            "GET_URL" => [ "GET", "application/x-www-form-urlencoded" ],
            "POST_URL" => [ "POST", "application/x-www-form-urlencoded" ],
            "PUT_URL" => [ "PUT", "application/x-www-form-urlencoded" ],
            "PATCH_URL" => [ "PATCH", "application/x-www-form-urlencoded" ],
            "DELETE_URL" => [ "DELETE", "application/x-www-form-urlencoded" ],

            "GET_JSON" => [ "GET", "application/json" ],
            "POST_JSON" => [ "POST", "application/json" ],
            "PUT_JSON" => [ "PUT", "application/json" ],
            "PATCH_JSON" => [ "PATCH", "application/json" ],
            "DELETE_JSON" => [ "DELETE", "application/json" ],

            "GET_MULTIPART" => [ "GET", "multipart/form-data" ],
            "POST_MULTIPART" => [ "POST", "multipart/form-data" ],
            "PUT_MULTIPART" => [ "PUT", "multipart/form-data" ],
            "PATCH_MULTIPART" => [ "PATCH", "multipart/form-data" ],
            "DELETE_MULTIPART" => [ "DELETE", "multipart/form-data" ]
        ];

        $contentType = getallheaders();
        $contentType = $contentType["Content-Type"] ?? "";
        $method = $_SERVER["REQUEST_METHOD"];

        $requestType = [ $method, $contentType ];

        switch ($requestType) {
            case $requestsTable["GET_JSON"]: {
                echo "json";
                break;
            }
            case $requestsTable["GET_MULTIPART"]: {
                echo "aqui";
                break;
            }
        }

        $input = file_get_contents("php://input");

        if ($contentType == "application/json") {
            $body = json_decode($input, true);
            return $body;
        }
        else {
            parse_str($input, $body);
            return $body;
        }
    }
}
