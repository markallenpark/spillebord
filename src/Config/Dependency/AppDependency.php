<?php

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

class AppDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            AppFactory::setContainer(container: $container);
            return AppFactory::create();
        };
    }
}
