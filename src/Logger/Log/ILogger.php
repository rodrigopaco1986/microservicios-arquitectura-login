<?php

namespace Rpj\Login\Logger\Log;

interface ILogger
{
    /**
     * System is unusable.
     *
     * @param  mixed[]  $context
     */
    public function emergency(string $message, array $context = []): bool;

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param  mixed[]  $context
     */
    public function alert(string $message, array $context = []): bool;

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param  mixed[]  $context
     */
    public function critical(string $message, array $context = []): bool;

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param  mixed[]  $context
     */
    public function error(string $message, array $context = []): bool;

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param  mixed[]  $context
     */
    public function warning(string $message, array $context = []): bool;

    /**
     * Normal but significant events.
     *
     * @param  mixed[]  $context
     */
    public function notice(string $message, array $context = []): bool;

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param  mixed[]  $context
     */
    public function info(string $message, array $context = []): bool;

    /**
     * Detailed debug information.
     *
     * @param  mixed[]  $context
     */
    public function debug(string $message, array $context = []): bool;

    /**
     * Logs with an arbitrary level.
     *
     * @param  mixed  $level
     * @param  mixed[]  $context
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, string $message, array $context = []): bool;
}
