<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class Required extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo es requerido";
    }

    public function isValid(string $field, array $inputs): bool {
        return isset($inputs[$field]) && $inputs[$field] !== "" && $inputs[$field] !== [];
    }
}
