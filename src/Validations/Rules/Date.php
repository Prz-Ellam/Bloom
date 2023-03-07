<?php

namespace Bloom\Validations\Rules;

use Bloom\Validations\ValidationRule;
use Attribute;
use DateTime;

#[Attribute]
class Date extends ValidationRule {
    public function __construct(?string $message = null) {
        $this->message = $message ?? "El campo no es una fecha";
    }

    public function isValid(string $field, array $inputs): bool {
        $format = 'Y-m-d';
        $d = DateTime::createFromFormat($format, $inputs[$field]);
        return $d && $d->format($format) === $inputs[$field];
    }
}
