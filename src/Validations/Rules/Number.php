<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class Number extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo debe ser un número";
    }

    public function isValid(mixed $input): bool {
        return isset($input) && is_numeric($input);
    }
}
