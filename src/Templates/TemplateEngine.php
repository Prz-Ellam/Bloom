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
    private string $extension = "php";

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
     * Set the template file extension
     *
     * @param string $extension
     * @return self
     */
    public function setExtension(string $extension): self {
        $this->extension = $extension;
        return $this;
    }

    /**
     * Returns HTML content for a PHP Template
     *
     * @param string $template
     * @return string
     */
    public function render(string $templateName, array $parameters = []): string {
        $template = new Template($this->basePath, $this->extension, $parameters);
        return $template->render($templateName);
    }
}
