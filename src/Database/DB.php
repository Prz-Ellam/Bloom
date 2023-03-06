<?php

namespace Bloom\Database;

use Bloom\Application;

class DB {
    public static function executeNonQuery(string $query, array $parameters) {
        Application::app()->getDatabaseDriver()->executeNonQuery($query, $parameters);
    }

    public static function executeReader(string $query, array $parameters) {
        Application::app()->getDatabaseDriver()->executeReader($query, $parameters);
    }
}
