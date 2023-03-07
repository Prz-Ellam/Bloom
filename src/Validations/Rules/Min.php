<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class Min extends ValidationRule {
    private int $min;

    public function __construct(int $min, ?string $message = null) {
        $this->min = $min;
        $this->message = $message ?? "El campo tiene un valor mayor a $this->min";
    }

    public function isValid(mixed $input): bool {
        return $input > $this->min;
    }
}
