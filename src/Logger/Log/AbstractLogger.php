<?php

namespace Rpj\Login\Logger\Log;

abstract class AbstractLogger implements ILogger
{
    use TLogger;

    /**
     * Replace vars from the context into the message to be logged.
     *
     * Example
     * Message: "{user} has logged in on {datetime}".
     * Context: ['user' => 'administrator', 'datetime' => '2024-01-01 10:00:30 AM']
     */
    protected function replaceContext(string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (is_string($val)) {
                $replace['{'.$key.'}'] = $val;
            }
        }

        return strtr($message, $replace);
    }
}
