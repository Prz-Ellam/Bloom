<?php

namespace Bloom\Database;

use Bloom\Application;

class DB {
    public static function beginTransaction(): bool {
        return Application::app()->getDatabaseDriver()->beginTransaction();
    }

    public static function inTransaction(): bool {
        return Application::app()->getDatabaseDriver()->inTransaction();
    }

    public static function commit(): bool {
        return Application::app()->getDatabaseDriver()->commit();
    }

    public static function rollBack(): bool {
        return Application::app()->getDatabaseDriver()->rollBack();
    }

    public static function executeNonQuery(string $query, array $parameters, array $types = []): int {
        return Application::app()->getDatabaseDriver()->executeNonQuery($query, $parameters, $types);
    }

    public static function executeOneReader(string $query, array $parameters, array $types = []): array {
        return Application::app()->getDatabaseDriver()->executeOneReader($query, $parameters, $types);
    }

    public static function executeReader(string $query, array $parameters, array $types = []): array {
        return Application::app()->getDatabaseDriver()->executeReader($query, $parameters, $types);
    }

    public static function lastInsertId(): string {
        return Application::app()->getDatabaseDriver()->lastInsertId();
    }
}
