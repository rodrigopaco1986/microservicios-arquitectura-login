<?php

namespace Rpj\Login\Logger\Log;

trait TLogger
{
    public function emergency(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    public function alert(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::ALERT, $message, $context);
    }

    public function critical(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::CRITICAL, $message, $context);
    }

    public function error(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::ERROR, $message, $context);
    }

    public function warning(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::WARNING, $message, $context);
    }

    public function notice(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::NOTICE, $message, $context);
    }

    public function info(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::INFO, $message, $context);
    }

    public function debug(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::DEBUG, $message, $context);
    }

    abstract public function log($level, string $message, array $context = []): bool;
}
