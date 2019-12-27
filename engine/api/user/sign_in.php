<?php

use Exception\InvalidCredentialsException;
use Exception\IllegalArgumentException;
use Database\MySQLi;

$request = json_decode(file_get_contents("php://input"), true);
$mysqli = new MySQLi();

if (authByToken($mysqli)) http_response_code(204);
else if (isset($request['login']) && isset($request['password'])) {
    if ($mysqli->authentication($request['login'], $request['password'])) {
        $userId = $mysqli->getUserId($request['login']);
        setcookie('id', $userId, time() + 86400, '/');
        setcookie('login', $request['login'], time() + 86400, '/');
        setcookie('token', $mysqli->authorization($userId), time() + 86400, '/');
        http_response_code(204);
    } else
        throw new InvalidCredentialsException("User or password is invalid");
} else
    throw new IllegalArgumentException();

// everyone and everything is invalid!
