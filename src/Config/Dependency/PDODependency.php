<?php

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Map\Spillebord\Config\Config;
use PDO;
use Psr\Container\ContainerInterface;

class PDODependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            $config = $container->get(Config::class);
            $config->loadConfigFile('db');

            // Get our configuration
            $socket = $config->get('db.socket');
            $host = $config->get('db.host');
            $port = $config->get('db.port');
            $name = $config->get('db.name');
            $user = $config->get('db.user');
            $pass = $config->get('db.pass');

            // Prep our DSN
            if ($socket === null) {
                $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
            } else {
                $dsn = "mysql:unix_socket=$socket;dbname=$name;charset=utf8mb4";
            }

            // Configure our options
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => false,
                PDO::ATTR_EMULATE_PREPARES => true,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];

            // Open connection
            return new PDO(
                $dsn,
                $user,
                $pass,
                $options
            );
        };
    }
}
