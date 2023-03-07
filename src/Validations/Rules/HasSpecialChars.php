<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class HasSpecialChars extends ValidationRule {
    private const REGEX = "/[¡”\"#$%&;\/=’?!¿:;,.\-_+*{}\[\]]/";

    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo ocupa al menos un carácter especial";
    }

    public function isValid(mixed $input): bool {
        return preg_match($this::REGEX, $input);
    }
}
