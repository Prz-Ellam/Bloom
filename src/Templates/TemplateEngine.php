<?php

namespace Bloom\Templates;

/**
 * HTML Template Engine
 */
class TemplateEngine {
    /**
     * path of the folder that contains the Templates
     *
     * @var string
     */
    private string $basePath = "";

    public function __construct(string $basePath) {
        $this->basePath = $basePath;
    }

    /**
     * Get the value of basePath
     *
     * @return string
     */ 
    public function getBasePath(): string {
        return $this->basePath;
    }

    /**
     * Set the value of the basePath
     *
     * @param string $basePath
     * @return self
     */
    public function setBasePath(string $basePath): self {
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * Returns HTML content for a PHP Template
     *
     * @param string $template
     * @return string
     */
    public function render(string $template, array $parameters = []): string {
        ob_start();
        include_once "$this->basePath/$template.php";
        return ob_get_clean();
    }
}
