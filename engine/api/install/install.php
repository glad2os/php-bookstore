<?php

use Exception\DbConnectionException;
use Database\MySQLi;
use Exception\DbException;

$request = json_decode(file_get_contents("php://input"), true);

try {
    $mysqli = new MySQLi();
    http_response_code(204);
} catch (DbConnectionException $e) {
    $request['count'] = (int)$request['count'];

    $fp = fopen(__DIR__ . "/../../config/Database.php", 'w');
    fwrite($fp, <<<PHP
<?php

namespace Config;

class Database
{
    const HOST = "${request['db_host']}";
    const USER = "${request['db_user']}";
    const PASSWORD = "${request['db_password']}";
    const DATABASE = "${request['db_schema']}";
}
PHP
    );
    fclose($fp);
    $fp = fopen(__DIR__ . "/../../config/Books.php", 'w');
    fwrite($fp, <<<PHP
<?php

namespace Config\Books;

const BOOKS_ON_PAGE = ${request['count']};
PHP
    );
    fclose($fp);

    $mysqli = new \MySQLi($request['db_host'], $request['db_user'], $request['db_password'], $request['db_schema']);
    $mysqli->query(<<<SQL
CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `login` text COLLATE utf8_bin NOT NULL,
 `password_hash` text COLLATE utf8_bin NOT NULL,
 `first_name` text COLLATE utf8_bin NOT NULL,
 `second_name` text COLLATE utf8_bin NOT NULL,
 `last_name` text COLLATE utf8_bin NOT NULL,
 `permissions` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `addresses` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `index` int(11) NOT NULL,
 `city` text COLLATE utf8_bin NOT NULL,
 `street` text COLLATE utf8_bin NOT NULL,
 `house` text COLLATE utf8_bin NOT NULL,
 `apartments` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `authors` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` text COLLATE utf8_bin NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `books` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` text COLLATE utf8_bin NOT NULL,
 `isbn` text COLLATE utf8_bin NOT NULL,
 `price` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `authors_links` (
 `author_id` int(11) DEFAULT NULL,
 `book_id` int(11) DEFAULT NULL,
 KEY `author_id` (`author_id`),
 KEY `book_id` (`book_id`),
 CONSTRAINT `author_id` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `orders` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `user_id` int(11) NOT NULL,
 `shipping_addresses_id` int(11) NOT NULL,
 `sum_order` int(11) NOT NULL,
 `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `order_user_id` (`user_id`),
 KEY `shipping_addresses_id` (`shipping_addresses_id`),
 CONSTRAINT `shipping_addresses_id` FOREIGN KEY (`shipping_addresses_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `order_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `orders_parts` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `order_id` int(11) NOT NULL,
 `book_id` int(11) NOT NULL,
 `price` int(11) NOT NULL,
 `count` int(3) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `parts_order_id` (`order_id`),
 KEY `parts_book_id` (`book_id`),
 CONSTRAINT `parts_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `parts_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
CREATE TABLE `tokens` (
 `user_id` int(11) NOT NULL,
 `token` varchar(32) COLLATE utf8_bin NOT NULL,
 `expiration` datetime NOT NULL,
 KEY `token_user_id` (`user_id`),
 CONSTRAINT `token_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
    $mysqli->query(<<<SQL
insert into users (login, password_hash, first_name, second_name, last_name, permissions) values ('${request['login']}', md5('${request['password']}'), '', '', '', 1);
SQL
    );
    if ($mysqli->errno) throw new DbException($mysqli->error, $mysqli->errno);
}