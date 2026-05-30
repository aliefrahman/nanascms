<?php

return [
    'host' => \Core\Config::env('DB_HOST', '127.0.0.1'),
    'dbname' => \Core\Config::env('DB_NAME', 'nanascms_db'),
    'username' => \Core\Config::env('DB_USER', 'root'),
    'password' => \Core\Config::env('DB_PASS', 'CDP17s1850913#^_^'),
    'charset' => \Core\Config::env('DB_CHARSET', 'utf8mb4'),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
