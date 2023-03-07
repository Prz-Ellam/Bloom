<?php

namespace Bloom\Tests\Validations;

use Bloom\Validations\Rules\Required;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase {
    /** @test */
    public function testRequired() {
        // Create require object
        $required = new Required();

        $valid = [
            " ",
            "a",
            "Hola Mundo",
            -1,
            0,
            1,
            1.2,
            2.5,
            true,
            false,
            [ 1, 2, 3]
        ];

        foreach ($valid as $key => $value) {
            $this->assertEquals(true, $required->isValid($key, $valid));
        }

        $notValid = [
            null,
            "",
            []
        ];

        foreach ($notValid as $key => $value) {
            $this->assertEquals(false, $required->isValid($key, $notValid));
        }

    }
}
