<?php

namespace Bloom\Session;

interface Session {
    public function create(): void;
    public function id();
    public function get(string $key);
    public function set(string $key, mixed $value);
    public function unset(string $key);
    public function has(string $key): bool;
    public function destroy();
}
