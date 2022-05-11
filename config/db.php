<?php declare(strict_types=1);

return [
    'socket' => null,
    'host' => $_ENV['db.host'] ?? 'localhost',
    'port' => $_ENV['db.port'] ?? 3306,
    'name' => $_ENV['db.name'] ?? 'spillebord',
    'user' => $_ENV['db.user'] ?? 'root',
    'pass' => $_ENV['db.pass'] ?? '',
];
