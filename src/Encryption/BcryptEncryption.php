<?php

namespace Rpj\Login\Encryption;

class BcryptEncryption implements IEncryption
{
    public function compare(string $original, string $new, array $optionsNew = []): bool
    {
        return password_verify($new, $original);
    }

    public function encrypt(string $text, array $options = []): string
    {
        $settings = [
            'cost' => $options['cost'] ?? 12,
        ];

        return password_hash($text, PASSWORD_BCRYPT, $settings);
    }
}
