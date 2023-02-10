<?php

namespace Bloom\Templates;

class Template {
    /**
     * Template path to render
     *
     * @var string
     */
    private string $templatePath = '';

    private ?string $layoutName = null;
    private array $layoutData = [];

    /**
     * Variables used in the template
     *
     * @var array
     */
    private array $data = [];

    public function __construct($data = []) {
        $this->data = $data;
    }

    public function section(string $template) {

    }

    public function layout(string $layoutName, array $layoutData = []) {
        $this->layoutName = $layoutName;
        $this->layoutData = $layoutData;
    }

    public function partial(string $template) {

    }

    public function __get(string $name): ?string {
        return $this->data[$name] ?? null;
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
