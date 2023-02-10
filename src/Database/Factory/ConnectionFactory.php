<?php

namespace Bloom\Database\Factory;

use Bloom\Database\Contracts\Connection;
use Bloom\Database\PDO\PDOConnection;

class ConnectionFactory {
    private function __construct() {

    }

    public static function createConnection(ConnectionType $connectionType): ?Connection {
        switch ($connectionType) {
            case ConnectionType::PDO:
                return new PDOConnection();
            case ConnectionType::MYSQLI:
                return null;
        }
        // Unsupported connection type
        return null;
    }
}
