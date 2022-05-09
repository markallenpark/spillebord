<?php

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Psr\Container\ContainerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;

class BasePathMiddlewareDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            return new BasePathMiddleware($container->get(App::class));
        };
    }
}
