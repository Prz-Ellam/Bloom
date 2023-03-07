<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class HasMayus extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo ocupa al menos una mayúscula";
    }

    public function isValid(string $field, array $inputs): bool {
        return preg_match("/[A-Z]/", $inputs[$field]);
    }
}
