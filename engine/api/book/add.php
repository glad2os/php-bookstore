<?php

use Exception\ForbiddenException;
use Exception\IllegalArgumentException;
use Database\MySQLi;

$mysqli = new MySQLi();
if (!authByToken($mysqli) || !checkPermissions($mysqli)) throw new ForbiddenException();

$request = json_decode(file_get_contents("php://input"), true);

if ((!isset($request['title'])) ||
    (!isset($request['isbn'])) ||
    (!isset($request['price'])) ||
    (!isset($request['authors']))
) throw new IllegalArgumentException("Fields must be exists");

$bookId = $mysqli->addBook($request['title'], $request['isbn'], $request['price']);
foreach ($request['authors'] as $author) {
    $mysqli->linkAuthor($author, $bookId);
}
http_response_code(204);
print json_encode($books);
