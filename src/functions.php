<?php

use Rpj\Login\Database\IDatabase;
use Rpj\Login\Encryption\EncryptionFactory;
use Rpj\Login\Session;

function terminate()
{
    exit();
}

function getSessionValues(Session $session): array
{
    return [
        'logger' => $session->get(SESSION_LOGGER_NAME, DEFAULT_LOGGER),
        'encryption' => $session->get(SESSION_ENCRYPTION_NAME, DEFAULT_ENCRYPTION),
    ];
}

function registerClient(IDatabase $database, array $data): bool
{
    return $database->insert(
        DB_TABLE_CLIENTS,
        $data,
    );
}

function buildClientData(Session $session, string $name, string $email, string $password): array
{
    $cryptClassName = $session->get(SESSION_ENCRYPTION_NAME, DEFAULT_ENCRYPTION);

    return [
        'name' => $name,
        'email' => $email,
        'password' => EncryptionFactory::factory($cryptClassName)->encrypt($password),
        'password_crypt' => $cryptClassName,
    ];
}
