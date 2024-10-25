<?php

header('Content-Type: application/json');

include 'vendor/autoload.php';

use Rpj\Login\Database\DatabaseFactory;
use Rpj\Login\Encryption\EncryptionFactory;
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
    $logger->notice('User with email: {email} attempted to log in incorrectly.', ['email' => $email]);
    $response->setValues(false, 'Email/Password are required!');
}

//User with email does not exists in DB
$clientRows = $database->select(DB_TABLE_CLIENTS, ['*'], 'email = ?', [$email]);
if ($clientRows) {
    $client = reset($clientRows);
    $encryptor = EncryptionFactory::factory($client['password_crypt']);

    if ($encryptor->compare($client['password'], $password)) {
        $logger->info('User {name} with email: {email} has successfully logged in.', ['name' => $client['name'], 'email' => $email]);
        $response->setValues(true, '', ['name' => $client['name'], 'email' => $email]);
    } else {
        $logger->notice('User with email: {email} attempted to log in with wrong password.', ['email' => $email]);
        $response->setValues(false, 'Invalid credentials!');
    }
} else {
    $logger->notice('User with email: {email} attempted to log in, but he was not found in database.', ['email' => $email]);
    $response->setValues(false, 'Client not found!', ['email' => $email]);
}

echo json_encode($response->toArray());
$response->terminate();
