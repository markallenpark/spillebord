<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Odan\Session\Middleware\SessionMiddleware;
use Odan\Session\SessionInterface;
use Psr\Container\ContainerInterface;

class SessionMiddlewareDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            return new SessionMiddleware(session: $container->get(SessionInterface::class));
        };
    }
}
