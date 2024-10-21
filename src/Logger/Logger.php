<?php

namespace Rpj\Login\Logger;

use Rpj\Login\Logger\Concrete\ILoggerHandler;
use Rpj\Login\Logger\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    protected const DEFAULT_DATETIME_FORMAT = 'c';

    public function __construct(private ILoggerHandler $handler) {}

    public function log($level, string $message, array $context = []): bool
    {
        return $this->handler->handle([
            'level' => strtoupper($level),
            'message' => $this->replaceContext($message, $context),
            'timestamp' => (new \DateTimeImmutable)->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }
}
