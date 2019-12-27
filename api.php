<?php

include_once __DIR__ . '/engine/config/Books.php';
include_once __DIR__ . '/engine/config/Database.php';
include_once __DIR__ . '/engine/database/MySQLi.php';
include_once __DIR__ . '/engine/exceptions/DbConnectionException.php';
include_once __DIR__ . '/engine/exceptions/DbException.php';
include_once __DIR__ . '/engine/exceptions/ForbiddenException.php';
include_once __DIR__ . '/engine/exceptions/IllegalArgumentException.php';
include_once __DIR__ . '/engine/exceptions/InvalidCredentialsException.php';
include_once __DIR__ . '/engine/helpers/auth.php';

try {
    header('Content-Type: application/json');
    http_response_code(200);
    include __DIR__ . "/engine/api/$routes[2]/$routes[3].php";
} catch (RuntimeException $e) {
    http_response_code(500);
    print json_encode([
        'issueType' => substr(strrchr(get_class($e), "\\"), 1),
        'issueMessage' => $e->getMessage(),
        'issueCode' => $e->getCode()
    ]);
}
