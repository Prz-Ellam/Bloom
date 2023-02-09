<?php

namespace Bloom\Session;

class PhpNativeSession implements Session {
    public function create(): void {
        session_start();
    }

    public function id(): string|false {
        return session_id();
    }

    public function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, mixed $value) {
        $_SESSION[$key] = $value;
    }

    public function unset(string $key) {
        unset($_SESSION[$key]);
    }

    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public function destroy() {
        session_unset();
        session_destroy();
    }
}
