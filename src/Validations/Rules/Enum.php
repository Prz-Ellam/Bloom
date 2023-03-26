<?php

namespace Bloom\Validations\Rules;

use Attribute;
use Bloom\Validations\ValidationRule;

#[Attribute]
class Enum extends ValidationRule {
    private array $elements;

    public function __construct(array $elements, ?string $message = null) {
        $this->elements = $elements;
        $this->message = $message ?? "El campo no es una fecha";
    }

    public function isValid(string $field, array $inputs): bool {
        return in_array($inputs[$field], $this->elements);
    }
}
