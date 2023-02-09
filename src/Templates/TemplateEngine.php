<?php

namespace Bloom\Templates;

/**
 * HTML Template Engine
 */
class TemplateEngine {
    private string $basePath = "";

    public function __construct() {
        
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
    public function render(string $template): string {
        ob_start();
        include_once "$this->basePath/$template.php";
        return ob_get_clean();
    }
}
