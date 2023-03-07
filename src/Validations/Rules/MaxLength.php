<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class MaxLength extends ValidationRule {
    private int $maxLength;

    public function __construct(int $maxLength, ?string $message = null) {
        $this->maxLength = $maxLength;
        $this->message = $message ?? "El campo debe medir menos de $this->maxLength carácteres";
    }

    public function isValid(string $field, array $inputs): bool {
        return strlen($inputs[$field]) <= $this->maxLength;
    }
}
