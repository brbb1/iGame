<?php

declare(strict_types=1);

return static function (): array {
    return [
        'dns' => 'mysql:host=' . $_ENV['MYSQL_HOST'] . ':' . $_ENV['MYSQL_PORT'] . ';dbname=' . $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_USER'],
        'password' => $_ENV['MYSQL_PASSWORD'],
    ];
};