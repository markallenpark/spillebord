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
            $config->loadConfigFile('database');

            $dsn = "sqlite:" . $config->get('database.file');
            return new PDO(
                $dsn,
                $config->get('database.options')
            );
        };
    }
}
