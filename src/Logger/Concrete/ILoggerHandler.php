<?php

namespace Rpj\Login\Logger\Concrete;

interface ILoggerHandler
{
    public const DEFAULT_FORMAT = '%timestamp% [%level%]: %message%';

    public function handle(array $vars): bool;
}
