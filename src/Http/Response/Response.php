<?php

namespace Bloom\Http\Response;

use Bloom\Application;
use Bloom\Http\HttpStatusCode;

class Response {
    private HttpStatusCode $code = HttpStatusCode::OK;
    private array $headers = [];
    private array $cookies = [];
    private ?string $body = "";

    /**
     * Set the status code for the HTTP Response
     *
     * @param integer|HttpStatusCode $code
     * @return self
     */
    public function setStatus(int|HttpStatusCode $code): self {
        if ($code instanceof HttpStatusCode) {
            $this->code = $code;
        }
        else {
            $this->code = HttpStatusCode::from($code);
        }
        return $this;
    }

    public function getStatus(): HttpStatusCode {
        return $this->code;
    }

    public function setCookie(string $name, string $value, int $minutes): self {
        $this->cookies[$name] = [ $value, $minutes ];
        return $this;
    }

    public function setContentType(string $value): self {
        $this->headers["Content-Type"] = $value;
        return $this;
    }

    public function setHeader(string $header, string $value): self {
        $this->headers[$header] = $value;
        return $this;
    }

    public function getHeader(string $header): string {
        return $this->headers[$header];
    }

    public function getBody(): ?string {
        return $this->body;
    }

    public function setBody(?string $body): self {
        $this->body = $body;
        return $this;
    }

    /**
     * Returns a HTTP Response as string
     *
     * @param string $data
     * @return self
     */
    public function send(string $data): self {
        $this
            ->setContentType("text/plain")
            ->setBody($data);
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

    /**
     * Returns a HTTP Response as HTML Template
     *
     * @param string $view
     * @return self
     */
    public function render(string $view): self {
        $templateEngine = Application::app()->getTemplateEngine();
        $html = $templateEngine->render($view);
        $this
            ->setContentType("text/html")
            ->setBody($html);

        // delete this
        header("Content-Type: text/html");
        print($html);
        
        return $this;
    }

    public function redirect(string $uri) {
        $this
            ->setHeader("Location", $uri);
    }

    public function download(string $file) {

    }

    public function file(string $name) {

    }
}
