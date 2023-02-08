<?php

namespace Bloom\Router;

use Closure;

class Route {
    private string $routeUri;
    private Closure|array $action;
    private string $regexUri;
    private array $parameters;
    private const URI_VARIABLES_REGEX = "/:([^\/]+)/";

    public function __construct(string $routeUri, Closure|array $action) {
        $this->routeUri = $routeUri;
        $this->action = $action;

        $matches = [];
        preg_match_all(self::URI_VARIABLES_REGEX, $this->routeUri, $matches);
        $this->parameters = $matches[1] ?? [];

        $regexUri = $this->routeUri;
        foreach ($this->parameters as $parameter) {
            $regexUri = preg_replace("/:$parameter/", "(?<$parameter>[A-Za-z0-9-._~:?#\[\]@!$&'()*+,;=]+)", $regexUri);
        }
        $this->regexUri = $regexUri;
    }

    public function getRouteUri(): string {
        return $this->routeUri;
    }

    public function getAction(): Closure|array {
        return $this->action;
    }

    public function getParameters(string $uri): array {
        $parameters = [];
        preg_match("#$this->regexUri#", $uri, $parameters);

        foreach ($parameters as $key => $value) {
            if (!in_array($key, $this->parameters)) {
                unset($parameters[$key]);
            }
        }
        return $parameters;
    }

    public function match(string $uri): bool {
        return preg_match("#^$this->regexUri$#", $uri);
    }
}
