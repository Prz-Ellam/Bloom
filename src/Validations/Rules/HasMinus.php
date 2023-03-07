<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class HasMinus extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo ocupa al menos una minúscula";
    }

    public function isValid(mixed $input): bool {
        return preg_match("/[a-z]/", $input);
    }
}
