<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;

class ResponseFactoryInterfaceDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            return $container->get(Psr17Factory::class);
        };
    }
}
