<?php

namespace Rpj\Login\Logger\Concrete;

use Rpj\Login\Database\IDatabase;

class DatabaseLogger implements ILoggerHandler
{
    use TFormatter;

    private $database;

    public function __construct(
        IDatabase $database,
        public string $tableName = 'logs',
        public string $columnName = 'data',
    ) {
        $this->database = $database;
    }

    public function handle(array $vars): bool
    {
        $output = $this->formatLog(self::DEFAULT_FORMAT, $vars);
        $data = [$this->columnName => $output];
        $this->database->insert($this->tableName, $data);

        return true;
    }
}
