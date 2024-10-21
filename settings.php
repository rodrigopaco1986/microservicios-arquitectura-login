<?php

header('Content-Type: application/json');

include 'vendor/autoload.php';
include 'constants.php';

use Rpj\Login\Encryption\BcryptEncryption;
use Rpj\Login\Encryption\CryptEncryption;
use Rpj\Login\Encryption\MD5Encryption;
use Rpj\Login\Encryption\NullEncryption;
use Rpj\Login\Logger\Concrete\DatabaseLogger;
use Rpj\Login\Logger\Concrete\FileLogger;
use Rpj\Login\Logger\Concrete\HttpLogger;
use Rpj\Login\Logger\Concrete\NullLogger;
use Rpj\Login\Response;
use Rpj\Login\Session;

$session = new Session;
$response = new Response;

$logger = $_POST['logger'] ?? false;
$encryption = $_POST['encryption'] ?? false;

if (! $logger && ! $encryption) {

    $response = new Response(false, 'Selected logger/encryption are missing!');

} else {

    if ($logger) {

        $loggerClass = match ($logger) {
            'file' => FileLogger::class,
            'http' => HttpLogger::class,
            'database' => DatabaseLogger::class,
            'none' => NullLogger::class,
            default => false,
        };

        if ($loggerClass) {
            $session->set(SESSION_LOGGER_NAME, $loggerClass);
        } else {
            $response = new Response(false, 'Available loggers: file, http, database, none.',
            );
        }

    }

    if ($encryption) {

        $encryptionClass = match ($encryption) {
            'md5' => MD5Encryption::class,
            'crypt' => CryptEncryption::class,
            'bcrypt' => BcryptEncryption::class,
            'none' => NullEncryption::class,
            default => false,
        };

        if ($encryptionClass) {
            $session->set(SESSION_ENCRYPTION_NAME, $encryptionClass);
        } else {
            $response = new Response(false, 'Availables encryptions: md5, crypt, bcrypt, none.');
        }

    }

    $response->setData(getSessionValues($session));

}

echo json_encode($response->toArray());
exit();

function getSessionValues(Session $session): array
{
    return [
        'logger' => $session->get(SESSION_LOGGER_NAME, DEFAULT_LOGGER),
        'encryption' => $session->get(SESSION_ENCRYPTION_NAME, DEFAULT_ENCRYPTION),
    ];
}
