<?php
return [
    'driver' => 'mysql',
    'mysql'  => [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'dbname'   => 'php_erp',
        'username' => 'root',
        'password' => '0214',
        'charset'  => 'utf8mb4',
    ],
    'sqlite' => [
        'path' => BASE_PATH . '/storage/database.sqlite',
    ],
];
