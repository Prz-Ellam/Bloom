<?php

namespace Bloom\Http\Request;

use Bloom\Http\HttpMethod;

class Request {
    private string $uri;
    private HttpMethod $method;
    private array $headers;
    private array $query;
    private array $body;
    private array $params;
    private array $files;

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

    public function getHeaders($header = null): array|string|null {
        if (is_null($header)) {
            return $this->headers;
        }
        return $this->headers[$header] ?? null;
    }

    public function setHeaders(array $headers): self {
        $this->headers = $headers;
        return $this;
    }

    public function getQuery($name = null): array|string|null {
        if (is_null($name)) {
            return $this->query;
        }
        return $this->query[$name] ?? null;
    }

    public function setQuery(array $query): self {
        $this->query = $query;
        return $this;
    }

    public function getBody($name = null): array|string|null {
        if (is_null($name)) {
            return $this->body;
        }
        return $this->body[$name] ?? null;
    }

    public function setBody(array $body): self {
        $this->body = $body;
        return $this;
    }

    public function getParams($name = null): array|string|null {
        if (is_null($name)) {
            return $this->params;
        }
        return $this->params[$name] ?? null;
    }

    public function setParams(array $params): self {
        $this->params = $params;
        return $this;
    }

    public function getFiles($name = null): array|string|null {
        if (is_null($name)) {
            return $this->files;
        }
        return $this->files[$name] ?? null;
    }

    public function setFiles(array $files): self {
        $this->files = $files;
        return $this;
    }

    public function __get(string $name): string {
        return $this->body[$name] ?? null;
    }
}
