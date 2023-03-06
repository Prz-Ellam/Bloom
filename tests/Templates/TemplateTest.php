<?php

namespace Bloom\Tests\Templates;

use Bloom\Templates\TemplateEngine;
use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase {
    /** @test */
    public function testRenderSingleViewWithNoParameters() {
        $engine = new TemplateEngine(__DIR__ . "/Views");
        $content = $engine->render("NoParameters");
        $expected = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <h1>Hello World</h1>
                <h2>Goodbye World</h2>
            </body>
            </html>
        ';

        $this->assertEquals(
            preg_replace("/\s*/", "", $expected),
            preg_replace("/\s*/", "", $content)
        );
    }

    public function testRenderSingleViewWithParameters() {
        $engine = new TemplateEngine(__DIR__ . "/Views");
        $content = $engine->render("Parameters", [ "variable" => 25 ]);
        $expected = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
            </head>
            <body>
                <h1>25</h1>
            </body>
            </html>
        ';

        $this->assertEquals(
            preg_replace("/\s*/", "", $expected),
            preg_replace("/\s*/", "", $content)
        );
    }

    public function testRenderViewWithLayout() {

    }

    public function testRenderViewWithParametersAndLayout() {

    }
}
