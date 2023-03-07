<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;

#[Attribute]
class Max extends ValidationRule {
    private int $max;

    public function __construct(int $max, ?string $message = null) {
        $this->max = $max;
        $this->message = $message ?? "El campo tiene un valor menor a $this->max";
    }

    public function isValid(mixed $input): bool {
        return $input <= $this->max;
    }
}
