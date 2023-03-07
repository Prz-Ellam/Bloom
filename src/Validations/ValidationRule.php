<?php

namespace Bloom\Validations;

abstract class ValidationRule {
    protected string $message;

    /**
     * Check if an input is valid with the rule
     *
     * @param mixed $input
     * @return boolean
     */
    public abstract function isValid(string $field, array $inputs): bool;
    
    public function message(): string {
        return $this->message;
    }
}
