<?php

namespace Rpj\Login\Logger\Concrete;

trait TFormatter
{
    public function formatLog(string $format, array $vars): string
    {
        $output = $format;
        foreach ($vars as $var => $val) {
            $output = str_replace('%'.$var.'%', $val, $output);
        }

        return $output;
    }
}
