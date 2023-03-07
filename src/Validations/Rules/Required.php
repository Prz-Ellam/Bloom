<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class Required extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo es requerido";
    }

    public function isValid(mixed $value): bool {
        return isset($value) && $value !== "" && $value !== [];
    }
}
