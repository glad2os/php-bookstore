<?php

use Exception\ForbiddenException;
use Database\MySQLi;

$mysqli = new MySQLi();
if (!authByToken($mysqli)) throw new ForbiddenException('Access Denied');

print json_encode($mysqli->getUserInfo($_COOKIE['id']));
