<?php

namespace Rpj\Login\Encryption;

interface IEncryption
{
    public function compare(string $original, string $new): bool;

    public function encrypt(string $text, array $options = []): string;
}
