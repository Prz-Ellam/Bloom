<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class HasNumber extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo ocupa al menos un número";
    }

    public function isValid(mixed $input): bool {
        return preg_match("/[0-9]/", $input);
    }
}
