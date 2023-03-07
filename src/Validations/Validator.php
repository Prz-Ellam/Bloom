<?php

namespace Bloom\Validations;

use ReflectionClass;
use ReflectionProperty;

class Validator {
    private object|array $instance;


    private array $feedback;
    private bool $valid;
    private ?bool $status;

    public function __construct(object|array $instance)
    {
        $this->instance = $instance;
        $this->status = null;
    }

    public function validate() : bool {
        if (is_object($this->instance)) {
            return $this->validateObject();
        }
        return false;
        // elseif (is_array($this->instance)) {
        //     return $this->validateArray();
        // }
        // else {
        //     return [];
        // }
    }

    /**
     * Validate a Model
     *
     * @return array
     */
    private function validateObject(): bool {
        $properties = $this->instance::getProperties();
        $values = $this->instance->toObject();
        $results = [];

        foreach ($properties as $property) {
            $reflectionProperty = new ReflectionProperty($this->instance::class, $property);
            $attributes = $reflectionProperty->getAttributes();

            foreach ($attributes as $attribute) {
                $attributeInstance = $attribute->newInstance();
                $class = new ReflectionClass($attributeInstance);
                $attributeName = $class->getShortName();
                $status = $attributeInstance->isValid($values[$property]);

                if ($status === false) {
                    $results[$property][$attributeName] = $attributeInstance->message();
                }
            }
        }

        $this->status = (count($results) === 0) ? true : false;
        $this->feedback = $results;
        return $this->status;
    }

    private function validateArray(): array
    {
        $results = [];

        foreach ($this->instance["rules"] as $property => $rules)
        {
            $status = false;
            if (is_array($rules))
            {
                foreach ($rules as $rule)
                {
                    $status = $rule->isValid($this->instance["values"][$property]);
                    $class = new ReflectionClass($rule);
                    $attributeName = $class->getShortName();
                    if (!$status)
                    {
                        $results[$property][$attributeName] = $rule->message();
                    }
                }
            }
            else
            {
                $status = $rules->isValid($this->instance["values"][$property]);
                $class = new ReflectionClass($rules);
                $attributeName = $class->getShortName();
                if (!$status)
                {
                    $results[$property][$attributeName] = $rules->message();
                }
            }

        }

        if (count($results) === 0)
        {
            $this->status = true;
        }
        else
        {
            $this->status = false;
        }

        return $results;
    }

    /**
     * Returns the Data Validation results
     *
     * @return array
     */
    public function getFeedback(): array {
        return $this->feedback;
    }

    public function getStatus() : ?bool {
        return $this->status;
    }
}
