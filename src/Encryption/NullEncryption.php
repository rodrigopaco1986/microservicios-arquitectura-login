<?php

namespace Rpj\Login\Encryption;

class NullEncryption implements IEncryption
{
    public function compare(string $original, string $new, array $optionsNew = []): bool
    {
        return $original == $new;
    }

    public function encrypt(string $text, array $options = []): string
    {
        return $text;
    }
}
