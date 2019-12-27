<?php

/**
 * @param $mysqli \Database\MySQLi
 * @return bool
 */
function authByToken($mysqli)
{
    return isset($_COOKIE['id']) && isset($_COOKIE['token']) && $mysqli->authByToken($_COOKIE['id'], $_COOKIE['token']);
}

/**
 * @param $mysqli \Database\MySQLi
 * @return bool
 */
function checkPermissions($mysqli)
{
    return isset($_COOKIE['id']) && $mysqli->getUserPermissions($_COOKIE['id']);
}
