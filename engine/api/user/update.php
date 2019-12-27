<?php

use Exception\ForbiddenException;
use Exception\IllegalArgumentException;
use Database\MySQLi;

$mysqli = new MySQLi();
if (!authByToken($mysqli)) throw new ForbiddenException('You are not logged in');

$request = json_decode(file_get_contents("php://input"), true);

if (!isset($request['login']) || !preg_match('/[-_#!0-9a-zA-Z]{3,}/', $request['login']))
    throw new IllegalArgumentException('Login is not set or does not match RegEx /[-_#!0-9a-zA-Z]{3,}/');

if (!isset($request['password']) || !preg_match('/.{8,}/', $request['password']))
    throw new IllegalArgumentException('Password is not set or does not match RegEx /.{8,}/');

if (!isset($request['first_name']) || !preg_match('/.{2,}/', $request['first_name']))
    throw new IllegalArgumentException('First name is not set or does not match RegEx /.{2,}/');

if (!isset($request['second_name']) || !preg_match('/.{2,}/', $request['second_name']))
    throw new IllegalArgumentException('Second name is not set or does not match RegEx /.{2,}/');

if (!isset($request['last_name']) || !preg_match('/.{2,}/', $request['last_name']))
    throw new IllegalArgumentException('Last name is not set or does not match RegEx /.{2,}/');

$mysqli->updateUser($_COOKIE['id'], $request['login'], $request['password'], $request['first_name'], $request['second_name'], $request['last_name']);

http_response_code(204);
