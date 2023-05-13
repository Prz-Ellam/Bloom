<?php

namespace Bloom\Templates;

class Template {
    /**
     * Template path to render
     *
     * @var string
     */
    private string $basePath = '';

    private ?string $layoutName = null;
    private array $layoutData = [];

    /**
     * Variables used in the template
     *
     * @var array
     */
    private array $parameters = [];
    private string $extension = "php";
    private string $fileExtension = "php";

    private string $content = "";

    public function __construct(string $basePath, string $extension, array $parameters = []) {
        $this->basePath = $basePath;
        $this->extension = $extension;
        $this->parameters = $parameters;
    }

    public function section(string $template) {

    }

    public function layout(string $layoutName, array $layoutData = []) {
        $this->layoutName = $layoutName;
        $this->layoutData = $layoutData;
    }

    public function partial(string $template) {

    }

    public function __get(string $name): mixed {
        // if (is_array($this->parameters[$name])) {
        //     return json_encode($this->parameters[$name]);
        // }
        return $this->parameters[$name] ?? null;
    }

    public function render(string $templateName): string {
        ob_start();
        include_once "$this->basePath/$templateName.$this->extension";
        $this->content = ob_get_clean();

        if (is_null($this->layoutName))
            return $this->content;
        else {
            return $this->renderLayout();
        }
    }

    public function renderLayout(): string {
        ob_start();
        include_once "$this->basePath/$this->layoutName.$this->extension";
        $this->layoutName = null;
        return ob_get_clean();
    }

    public function env(string $key) {
        return $_ENV[$key] ?? null;
    }
    
    public function session(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public function asset(string $name) {
        $content = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/dist/manifest.json");
        $content = json_decode($content, true);
        $file = $content[$name]["file"];
        return "/dist/$file";
    }

    public function script(string $name) {
        $content = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/dist/manifest.json");
        $content = json_decode($content, true);
        $file = $content[$name]["file"];
        return '<script defer type="module" src="/dist/' . $file . '"></script>';
    }

    public function link(string $name) {
        $content = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/dist/manifest.json");
        $content = json_decode($content, true);
        $file = $content[$name]["file"];
        return '<link rel="stylesheet" href="/dist/' . $file . '">';
    }
}

/**
 * 
 * Template
 * - url to the file in the filesystem
 * - data to send into the file
 * - desire syntax:  <h1> <?php $this->name ?> </h1>
 * $this->partial('template_name')
 * $this->section('section')
 * $this->layout('layout')
 * 
 */
