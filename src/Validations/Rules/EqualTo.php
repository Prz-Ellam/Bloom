<?php

namespace Bloom\Validations\Rules;

use Attribute;
use Bloom\Validations\ValidationRule;

#[Attribute]
class EqualTo extends ValidationRule {
    private string $fieldName;

    public function __construct(string $fieldName, ?string $message = null) {
        $this->fieldName = $fieldName;
        $this->message = $message ?? "El campo no coincide con $fieldName";
    }

    public function isValid(string $field, array $inputs): bool {
        return $inputs[$field] === $inputs[$this->fieldName];
    }
}
