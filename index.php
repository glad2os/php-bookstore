<?php

$routes = explode('/', $_SERVER['REQUEST_URI']);

if ($routes[1] == 'api') {
    include 'api.php';
} else {
    include 'page.php';
}
