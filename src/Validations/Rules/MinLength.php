<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class MinLength extends ValidationRule {
    private int $minLength;

    public function __construct(int $minLength, ?string $message = null) {
        $this->minLength = $minLength;
        $this->message = $message ?? "El campo debe medir más de $this->minLength carácteres";
    }

    public function isValid(mixed $value): bool {
        return strlen($value) >= $this->minLength;
    }
}
