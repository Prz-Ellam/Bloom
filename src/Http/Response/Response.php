<?php

namespace Bloom\Http\Response;

class Response {
    private int $code = 200;
    private array $headers = [];
    private ?string $body = "";

    public function status(int $code): self {
        $this->code = $code;
        return $this;
    }

    public function setContentType(string $value): self {
        $this->headers["Content-Type"] = $value;
        return $this;
    }

    public function setBody(?string $body): self {
        $this->body = $body;
        return $this;
    }

    public function json(mixed $data): self {
        $this
            ->setContentType("application/json")
            ->setBody(json_encode($data));
        return $this;
    }

    public function view() {
        
    }

    public function redirect() {

    }
}
