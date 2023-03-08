<?php

namespace Bloom\Database;

use Bloom\Database\DatabaseDriver;
use PDO;
use PDOException;

class PDODatabaseDriver implements DatabaseDriver {
    private ?PDO $pdo = null;

    public function connect(string $protocol, string $host, string $port, string $username, string $password, string $database) {
        $dsn = "$protocol:host=$host;port=$port;dbname=$database;charset=utf8";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            //die($ex->getMessage());
        }
    }

    public function disconnect() {
        $this->pdo = null;
    }

    public function beginTransaction() : bool{
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool {
        return $this->pdo->commit();
    }

    public function rollBack(): bool {
        return $this->pdo->rollBack();
    }

    public function lastInsertId(): string {
        return $this->pdo->lastInsertId();
    }

    public function inTransaction(): bool {
        return $this->pdo->inTransaction();
    }

    public function executeNonQuery(string $query, array $parameters): int {
        //try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($parameters);
            $rowCount = $statement->rowCount();
            return $rowCount;
        //}
        //catch (PDOException $exception) {
        //    if ($this->inTransaction()) {
        //        $this->rollback();
        //    }
        //    die($exception->getMessage());
        //}
    }

    public function executeOneReader(string $query, array $parameters): array {
        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return ($result !== false) ? $result : [];
    }

    public function executeReader(string $query, array $parameters): array {
        //try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($parameters);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        //} 
        //catch (PDOException $ex) {
        //    if ($this->inTransaction()) {
        //        $this->rollback();
        //    }
        //    die($ex->getMessage());
        //}
    }
}
