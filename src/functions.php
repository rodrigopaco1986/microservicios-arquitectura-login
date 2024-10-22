<?php

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