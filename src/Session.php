<?php

namespace Rpj\Login;

class Session
{
    public function __construct()
    {
        session_start();
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
