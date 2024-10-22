<?php

header('Content-Type: application/json');

include 'vendor/autoload.php';

use Rpj\Login\Database\DatabaseFactory;
use Rpj\Login\Database\IDatabase;
use Rpj\Login\Encryption\EncryptionFactory;
use Rpj\Login\Logger\LoggerFactory;
use Rpj\Login\Response;
use Rpj\Login\Session;

$session = new Session;
$response = $response ?? new Response;

$name = $_POST['name'] ?? false;
$email = $_POST['email'] ?? false;
$password = $_POST['password'] ?? false;

$loggerClassName = $session->get(SESSION_LOGGER_NAME, DEFAULT_LOGGER);
$logger = LoggerFactory::factory($loggerClassName);
$database = DatabaseFactory::factory(DEFAULT_DATABASE);

//Name/Email/Password are present in the request
if ($name !== false && $email !== false && $password !== false) {
    $clientRows = $database->select(DB_TABLE_CLIENTS, ['*'], 'email = ?', [$email]);
    if ($clientRows) {
        $logger->notice('A new client attempted to register with a taken email. Name: {name}. Email: {email}', ['name' => $name, 'email' => $email]);
        $response = new Response(false, 'User already registered with that email!');
    } else {
        $clientData = buildClientData($session, $name, $email, $password);
        registerClient($database, $clientData);
        $logger->info('A client was registered successfully. Name: {name}. Email: {email}', ['name' => $name, 'email' => $email]);
        $response = new Response(true, '', $clientData);
    }
} else {
    $logger->notice('An invalid request to register a client was sent. Name: {name}. Email: {email}', ['name' => $name, 'email' => $email]);
    $response = new Response(false, 'Name/Email/Password are required!');
}

echo json_encode($response->toArray());
$response->terminate();

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
