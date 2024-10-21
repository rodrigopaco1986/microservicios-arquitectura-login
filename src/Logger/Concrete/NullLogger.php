<?php

namespace Rpj\Login\Logger\Concrete;

/**
 * Logger used to avoid conditional log calls.
 */
class NullLogger implements ILoggerHandler
{
    use TFormatter;

    public function handle(array $vars): bool
    {
        return true;
    }
}
