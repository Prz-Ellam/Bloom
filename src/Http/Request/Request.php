<?php

namespace Bloom\Http\Request;

use Bloom\Http\HttpMethod;
use Bloom\Session\Session;

/**
 * Data structure with the HTTP Request data
 */
class Request {
    // baseUrl
    // [x] body
    // cookies
    // fresh
    // hostname
    // ip
    // ips
    // [x] method
    // [x] params
    // path
    // protocol
    // [x] query
    // secure
    // signed cookies
    // stale
    // subdomains
    // xhr

    // accepts
    //

    /**
     * HTTP URI for the Request
     *
     * @var string
     */
    private string $uri;

    /**
     * HTTP Method for the Request
     *
     * @var HttpMethod
     */
    private HttpMethod $method;

    /**
     * HTTP Request headers
     *
     * @var array<string, string>
     */
    private array $headers;

    /**
     * Query parameters
     *
     * @var array<string, string>
     */
    private array $query;

    /**
     * HTTP Request payload
     *
     * @var array<string, string>
     */
    private array $body;

    /**
     * Route parameters
     *
     * @var array<string, string>
     */
    private array $params;

    /**
     * Files send for the HTTP Request
     *
     * @var array
     */
    private array $files;

    /**
     * Cookies
     *
     * @var array
     */
    private array $cookies;

    /**
     * HTTP Session
     *
     * @var Session
     */
    private Session $session;

    public function getUri(): string {
        return $this->uri;
    }

    public function setUri(string $uri): self {
        $this->uri = $uri;
        return $this;
    }

    public function getMethod(): HttpMethod {
        return $this->method;
    }

    public function setMethod(HttpMethod $method): self {
        $this->method = $method;
        return $this;
    } 

    public function getHeaders($header = null, $default = null): array|string|null {
        if (is_null($header)) {
            return $this->headers;
        }
        return $this->headers[$header] ?? $default;
    }

    public function setHeaders(array $headers): self {
        $this->headers = $headers;
        return $this;
    }

    public function hasHeader(string $header): bool {
        return isset($this->headers[$header]);
    }

    public function getQuery($name = null, $default = null): array|string|null {
        if (is_null($name)) {
            return $this->query;
        }
        return $this->query[$name] ?? $default;
    }

    public function setQuery(array $query): self {
        $this->query = $query;
        return $this;
    }

    public function getBody($name = null, $default = null): array|string|null {
        if (is_null($name)) {
            return $this->body;
        }
        return $this->body[$name] ?? $default;
    }

    public function setBody(array $body): self {
        $this->body = $body;
        return $this;
    }

    public function getParams($name = null, $default = null): array|string|null {
        if (is_null($name)) {
            return $this->params;
        }
        return $this->params[$name] ?? $default;
    }

    public function setParams(array $params): self {
        $this->params = $params;
        return $this;
    }

    public function getFiles($name = null, $default = null): array|string|null {
        if (is_null($name)) {
            return $this->files;
        }
        return $this->files[$name] ?? $default;
    }

    public function setFiles(array $files): self {
        $this->files = $files;
        return $this;
    }

    public function getSession(): Session {
        return $this->session;
    }

    public function setSession(Session $session): self {
        $this->session = $session;
        return $this;
    }

    public function __get(string $name): string {
        return $this->body[$name] ?? $this->params[$name] ?? null;
    }
}
