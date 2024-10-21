<?php

namespace Rpj\Login\Logger\Concrete;

class FileLogger implements ILoggerHandler
{
    use TFormatter;

    public function __construct(private string $path)
    {
        $dir = dirname($path);
        if (! file_exists($dir)) {
            $status = mkdir($dir, 0777, true);
            if ($status === false && ! is_dir($dir)) {
                throw new \UnexpectedValueException(sprintf('There is no existing directory at "%s"', $dir));
            }
        }
    }

    public function handle(array $vars): bool
    {
        $output = $this->formatLog(self::DEFAULT_FORMAT, $vars);
        $success = file_put_contents($this->path, $output.PHP_EOL, FILE_APPEND);

        return $success !== false;
    }
}
