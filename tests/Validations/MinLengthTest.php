<?php

namespace Bloom\Tests\Validations;

use Bloom\Validations\Rules\MinLength;
use PHPUnit\Framework\TestCase;

class MinLengthTest extends TestCase {
    /** @test */
    public function testMinLength() {
        $minLength = new MinLength(5);

        $values = [
            "",
            "0",
            "01",
            "012",
            "0123"
        ];

        foreach ($values as $value) {
            $this->assertEquals(false, $minLength->isValid($value));
        }

        $valid = [
            "01234",
            "012345",
            "0123456",
            "01234567"
        ];

        foreach ($valid as $value) {
            $this->assertEquals(true, $minLength->isValid($value));
        }

    }
}
