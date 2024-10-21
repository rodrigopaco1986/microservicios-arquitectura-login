<?php

namespace Rpj\Login\Encryption;

class MD5Encryption implements IEncryption
{
    public function compare(string $original, string $new, array $optionsNew = []): bool
    {
        return $original == $this->encrypt($new, $optionsNew);
    }

    public function encrypt(string $text, array $options = []): string
    {
        return md5($text);
    }
}
