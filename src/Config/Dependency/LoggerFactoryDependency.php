<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Map\Spillebord\Config\Config;
use Map\Spillebord\Factory\LoggerFactory;
use Psr\Container\ContainerInterface;

class LoggerFactoryDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            return new LoggerFactory($container->get(Config::class));
        };
    }
}
