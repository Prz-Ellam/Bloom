<?php

namespace Bloom\Database\Contracts;

/**
 * Interface for implementing a Database connection
 */
interface Connection {
    public function beginTransaction();
    public function commit();
    public function rollBack();
    public function prepare(): Statement;
    public function lastInsertId();
    public function inTransaction();
    public function query();
}
