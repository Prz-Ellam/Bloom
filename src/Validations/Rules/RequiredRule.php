<?php

namespace Bloom\Validations\Rules;

class RequiredRule {
    private string $message = "";

    public function isValid(mixed $value): bool {
        return false;
    }

    public function getMessage(): string {
        return $this->message;
    }
}
