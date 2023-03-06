<?php

namespace Bloom\Database;

/**
 * Interface for implementing a Database connection
 */
interface DatabaseDriver {
    public function connect(
        string $protocol, 
        string $host, 
        string $port, 
        string $username, 
        string $password, 
        string $database
    );

    public function disconnect();

    // Inicia una transaccion
    public function beginTransaction(): bool;

    // Comprueba si una transaccion esta activa
    public function inTransaction(): bool;

    // Completa una transaccion
    public function commit(): bool;

    // Revierte una transaccion
    public function rollBack(): bool;

    // Ejecuta un insert
    public function executeNonQuery(string $query, array $parameters): int;

    // Ejecuta un reader
    public function executeReader(string $query, array $parameters): array;

    // Devuelve el ultimo id insertado
    public function lastInsertId(): string;
}
