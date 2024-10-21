<?php

namespace Rpj\Login\Logger;

use Rpj\Login\Database\SqliteDatabase;
use Rpj\Login\Logger\Concrete\DatabaseLogger;
use Rpj\Login\Logger\Concrete\FileLogger;
use Rpj\Login\Logger\Concrete\HttpLogger;
use Rpj\Login\Logger\Concrete\NullLogger;
use Rpj\Login\Logger\Log\ILogger;

final class LoggerFactory
{
    public static function factory(string $loggerClassname): ILogger
    {
        $concreteLogger = match ($loggerClassname) {
            FileLogger::class => new FileLogger(STORAGE_PATH.LOGGER_FILENAME),
            HttpLogger::class => new HttpLogger(LOGGER_HTTP_REQUEST_URL, LOGGER_HTTP_REQUEST_IS_GET, LOGGER_HTTP_REQUEST_DATA),
            DatabaseLogger::class => new DatabaseLogger(new SqliteDatabase(STORAGE_PATH.DB_NAME.'.sqlite'), DB_TABLE_LOG, DB_TABLE_LOG_COLUMN),
            default => new NullLogger,
        };

        return new Logger($concreteLogger);
    }
}
