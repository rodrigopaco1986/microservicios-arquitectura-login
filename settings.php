<?php

header('Content-Type: application/json');

include 'vendor/autoload.php';

use Rpj\Login\Encryption\BcryptEncryption;
use Rpj\Login\Encryption\CryptEncryption;
use Rpj\Login\Encryption\MD5Encryption;
use Rpj\Login\Encryption\NullEncryption;
use Rpj\Login\Logger\Concrete\DatabaseLogger;
use Rpj\Login\Logger\Concrete\FileLogger;
use Rpj\Login\Logger\Concrete\HttpLogger;
use Rpj\Login\Logger\Concrete\NullLogger;
use Rpj\Login\Logger\LoggerFactory;
use Rpj\Login\Response;
use Rpj\Login\Session;

$session = new Session;
$response = $response ?? new Response;

$logger = $_POST['logger'] ?? false;
$encryption = $_POST['encryption'] ?? false;

$loggerClassName = $session->get(SESSION_LOGGER_NAME, DEFAULT_LOGGER);
$loggerObj = LoggerFactory::factory($loggerClassName);

if (! $logger && ! $encryption) {

    $response->setValues(false, 'Selected logger/encryption are missing!');
    $loggerObj->notice('Logger was attempted to be updated with missing options!');

} else {

    if ($logger) {

        $loggerClass = match ($logger) {
            SETTINGS_LOGGER_FILE => FileLogger::class,
            SETTINGS_LOGGER_HTTP => HttpLogger::class,
            SETTINGS_LOGGER_DATABASE => DatabaseLogger::class,
            SETTINGS_LOGGER_NONE => NullLogger::class,
            default => false,
        };

        if ($loggerClass) {
            $session->set(SESSION_LOGGER_NAME, $loggerClass);
            $loggerObj->notice('Logger was uptated to: '.$loggerClass);
        } else {
            $response->setValues(false, 'Available loggers: file, http, database, none.');
            $loggerObj->notice('Logger was attempted to be updated with wrong option: '.$logger);
        }

    }

    if ($encryption) {

        $encryptionClass = match ($encryption) {
            SETTINGS_ENCRYPTION_MD5 => MD5Encryption::class,
            SETTINGS_ENCRYPTION_CRYPT => CryptEncryption::class,
            SETTINGS_ENCRYPTION_BCRYPT => BcryptEncryption::class,
            SETTINGS_ENCRYPTION_NONE => NullEncryption::class,
            default => false,
        };

        if ($encryptionClass) {
            $session->set(SESSION_ENCRYPTION_NAME, $encryptionClass);
            $loggerObj->notice('Encryption was uptated to: '.$encryptionClass);
        } else {
            $response->setValues(false, 'Availables encryptions: md5, crypt, bcrypt, none.');
            $loggerObj->notice('Encryption was attempted to be updated with wrong option: '.$encryption);
        }

    }

    $response->setData(getSessionValues($session));

}

echo json_encode($response->toArray());
$response->terminate();
