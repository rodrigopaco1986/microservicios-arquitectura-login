<?php

header('Content-Type: application/json');

include 'vendor/autoload.php';

use Rpj\Login\Database\DatabaseFactory;
use Rpj\Login\Encryption\EncryptionFactory;
use Rpj\Login\Logger\Log\ILogger;
use Rpj\Login\Logger\LoggerFactory;
use Rpj\Login\Response;
use Rpj\Login\Session;

$session = new Session;
$response = $response ?? new Response;

$email = $_POST['email'] ?? false;
$password = $_POST['password'] ?? false;

$loggerClassName = $session->get(SESSION_LOGGER_NAME, DEFAULT_LOGGER);
$logger = LoggerFactory::factory($loggerClassName);
$database = DatabaseFactory::factory(DEFAULT_DATABASE);

//Email/Password are missing from request
if ($email === false || $password === false) {
    failedResponse(
        $logger,
        'User with email: {email} attempted to log in incorrectly.',
        ['email' => $client['email']],
        'Email/Password are required!'
    );
}

//User with email does not exists in DB
$clientRows = $database->select(DB_TABLE_CLIENTS, ['*'], 'email = ?', [$email]);
if ($clientRows) {
    $client = reset($clientRows);
    //Logged in successfully
    $encryptor = EncryptionFactory::factory($client['password_crypt']);

    if ($encryptor->compare($client['password'], $password)) {
        successResponse(
            $logger,
            'User {name} with email: {email} has successfully logged in.',
            ['name' => $client['name'], 'email' => $email],
        );
        //Invalid credentials
    } else {
        failedResponse(
            $logger,
            'User with email: {email} attempted to log in with wrong password.',
            ['email' => $email],
            'Invalid credentials!'
        );
    }
} else {
    failedResponse(
        $logger,
        'User with email: {email} attempted to log in, but he was not found in database.',
        ['email' => $email],
        'Invalid credentials!'
    );
}

function successResponse(ILogger $logger, string $loggerMsg, array $loggerParams): void
{
    $logger->info($loggerMsg, $loggerParams);
    $response = new Response(true);
    echo json_encode($response->toArray());
    $response->terminate();
}

function failedResponse(ILogger $logger, string $loggerMsg, array $loggerParams, string $responseMsg): void
{
    $logger->notice($loggerMsg, $loggerParams);
    $response = new Response(false, $responseMsg);

    echo json_encode($response->toArray());
    $response->terminate();
}
