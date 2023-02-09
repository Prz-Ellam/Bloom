<?php

namespace Bloom\Http\Response;

use Bloom\Application;

class Response {
    private int $code = 200;
    private array $headers = [];
    private ?string $body = "";

    public function status(int $code): self {
        $this->code = $code;
        return $this;
    }

    public function getStatus(): int {
        return $this->code;
    }

    public function setContentType(string $value): self {
        $this->headers["Content-Type"] = $value;
        return $this;
    }

    public function setHeader(string $header, string $value): self {
        $this->headers[$header] = $value;
        return $this;
    }

    public function getBody(): ?string {
        return $this->body;
    }

    public function setBody(?string $body): self {
        $this->body = $body;
        return $this;
    }

    /**
     * Returns a HTTP Response as JSON
     *
     * @param mixed $data
     * @return self
     */
    public function json(mixed $data): self {
        $this
            ->setContentType("application/json")
            ->setBody(json_encode($data));
        return $this;
    }

    public function view(string $view) {

        $templateEngine = Application::app()->getTemplateEngine();
        $html = $templateEngine->render($view);
        $this
            ->setContentType("text/html")
            ->setBody($html);
    }

    public function redirect(string $uri) {

    }
}
