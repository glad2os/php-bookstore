<?php

use Exception\ForbiddenException;
use Database\MySQLi;

$mysqli = new MySQLi();
if (!authByToken($mysqli)) throw new ForbiddenException('You are not logged in');

$mysqli->invalidateToken($_COOKIE['id'], $_COOKIE['token']);
unset($_COOKIE['id']);
unset($_COOKIE['login']);
unset($_COOKIE['token']);
setcookie('id', null, -1, '/');
setcookie('login', null, -1, '/');
setcookie('token', null, -1, '/');

http_response_code(204);
