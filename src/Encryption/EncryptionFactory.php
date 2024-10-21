<?php

namespace Rpj\Login\Encryption;

final class EncryptionFactory
{
    public static function factory(string $encryptClassname): IEncryption
    {
        $concreteEncryption = match ($encryptClassname) {
            MD5Encryption::class => new MD5Encryption,
            CryptEncryption::class => new CryptEncryption,
            BcryptEncryption::class => new BcryptEncryption,
            default => new NullEncryption,
        };

        return $concreteEncryption;
    }
}
