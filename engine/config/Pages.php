<?php

use Database\MySQLi;

$pages = [
    '' => [
        'title' => 'GLADDOS.STUDIO',
        'content' => 'index.html',
        'scripts' => ['index_loader']
    ],
    'signup' => [
        'title' => 'Регистрация | GLADDOS.STUDIO',
        'content' => 'signup.html',
        'onselect' => function () {
            if (authByToken(new MySQLi())) {
                header('Location: /account');
                exit();
            }
        }
    ],
    'signin' => [
        'title' => 'Вход | GLADDOS.STUDIO',
        'content' => 'signin.html',
        'onselect' => function () {
            if (authByToken(new MySQLi())) {
                header('Location: /account');
                exit();
            }
        }
    ],
    'account' => [
        'title' => 'Личный кабинет | GLADDOS.STUDIO',
        'content' => 'account.html',
        'onselect' => function () {
            if (!authByToken(new MySQLi())) {
                header('Location: /signin');
                exit();
            }
        },
        'scripts' => ['account_loader']
    ],
    'catalog' => [
        'title' => 'Каталог | GLADDOS.STUDIO',
        'content' => 'catalog.html',
        'scripts' => ['catalog_loader']
    ],
    'admin' => [
        'title' => 'Панель администратора | GLADDOS.STUDIO',
        'content' => 'admin.html',
        'onselect' => function () {
            $mysqli = new MySQLi();
            if (!authByToken($mysqli)) {
                header('Location: /signin');
                exit();
            }
            if (!checkPermissions($mysqli)) {
                header('Location: /403');
                exit();
            }
        },
        'scripts' => ['admin_loader']
    ],
    '404' => [
        'title' => 'Не найдено | GLADDOS.STUDIO',
        'content' => '404.html'
    ],
    '403' => [
        'title' => 'Доступ запрещён | GLADDOS.STUDIO',
        'content' => '403.html'
    ],
    'install' => [
        'title' => 'Установщик',
        'content' => 'install.html'
    ]
];
