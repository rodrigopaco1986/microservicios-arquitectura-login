<?php

namespace Rpj\Login;

class Session
{
    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, $val): void
    {
        $_SESSION[$key] = $val;
    }
}
