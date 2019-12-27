<?php

use Exception\ForbiddenException;
use Exception\IllegalArgumentException;
use Database\MySQLi;

$mysqli = new MySQLi();
if (!authByToken($mysqli) || !checkPermissions($mysqli)) throw new ForbiddenException();

$request = json_decode(file_get_contents("php://input"), true);
if (!isset($request['name'])) throw new IllegalArgumentException("Fields must be exists");

$mysqli->addAuthor($request['name']);
http_response_code(204);
