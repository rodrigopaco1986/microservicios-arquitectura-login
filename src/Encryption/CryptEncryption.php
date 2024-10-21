<?php

namespace Rpj\Login\Encryption;

class CryptEncryption implements IEncryption
{
    public function compare(string $original, string $new, array $optionsNew = []): bool
    {
        return $original == $this->encrypt($new, $optionsNew);
    }

    public function encrypt(string $text, array $options = []): string
    {
        $salt = $options['salt'] ?? rand(8, 12);

        return crypt($text, $salt);
    }
}
