<?php

include_once __DIR__ . '/engine/config/Database.php';
include_once __DIR__ . '/engine/config/Pages.php';
include_once __DIR__ . '/engine/database/MySQLi.php';
include_once __DIR__ . '/engine/helpers/auth.php';

$current = $pages[$routes[1]];
if ($current == null) $current = $pages['404'];

if (isset($current['onselect'])) $current['onselect']();

$title = $current['title'];
$content = file_get_contents(__DIR__ . '/templates/' . $current['content']);
$scripts = '';
if (isset($current['scripts'])) {
    foreach ($current['scripts'] as $script) {
        $scripts .= "<script rel=\"script\" type=\"application/javascript\" src=\"/assets/js/${script}.js\"></script>";
    }
}
include __DIR__ . '/templates/page.html';
