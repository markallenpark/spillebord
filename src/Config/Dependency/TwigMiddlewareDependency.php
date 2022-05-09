<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

class TwigMiddlewareDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            return TwigMiddleware::createFromContainer(
                app: $container->get(App::class),
                containerKey: Twig::class
            );
        };
    }
}
