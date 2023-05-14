<?php

namespace Bloom\Database;

use Cursotopia\ValueObjects\EntityState;
use JsonSerializable;

abstract class Model implements JsonSerializable {
    protected EntityState $entityState;
    protected array $_ignores = [];

    public abstract function save(): bool;

    public function jsonSerialize(): mixed {
        $properties = get_object_vars($this);
        $output = [];
        
        foreach ($properties as $name => $value) {
            if (in_array($name, $this->_ignores)) {
                 continue;
            }

            if ($name == '_ignores') {
                continue;
            }

            if (!($value instanceof Repository) && !($value instanceof EntityState)) {
                $output[$name] = $value;
            }
        }
        
        return $output;
    }

    public function toArray(): ?array {
        return json_decode(json_encode($this), true);
    }

    public function setIgnores(array $ignores) {
        $this->_ignores = $ignores;
    }
}
