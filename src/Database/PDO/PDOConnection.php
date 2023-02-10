<?php

namespace Bloom\Database\PDO;

use Bloom\Database\Contracts\Connection;
use Bloom\Database\Contracts\Statement;
use PDO;

class PDOConnection implements Connection {
    private ?PDO $pdo = null;

    public function __construct() {
        $this->pdo = new PDO("", "username", "password", []);
    }

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    public function commit() {
        $this->pdo->commit();
    }

    public function rollBack() {
        $this->pdo->rollBack();
    }

    public function prepare(): Statement {
        // $query, $options
        $this->pdo->prepare("query", []);
        return new PDOStatement();
    }

    public function lastInsertId() {
        // $name
        $this->pdo->lastInsertId();
    }

    public function inTransaction() {
        $this->pdo->inTransaction();
    }

    public function query() {
        $this->pdo->query("statement", "mode", "fetch_mode");
    }
}
