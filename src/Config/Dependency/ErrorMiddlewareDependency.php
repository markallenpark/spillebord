<?php declare(strict_types=1);

namespace Map\Spillebord\Config\Dependency;

use Closure;
use Map\Spillebord\Config\Config;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

class ErrorMiddlewareDependency
{
    public function create() : Closure
    {
        return function (ContainerInterface $container) {
            $config = $container->get(Config::class);
            $config->loadConfigFile(name: 'error');
            $app = $container->get(App::class);
            $resolver = $app->getCallableResolver();
            $factory = $app->getResponseFactory();

            return new ErrorMiddleware(
                callableResolver: $resolver,
                responseFactory: $factory,
                displayErrorDetails: $config->get(key: 'error.displayErrorDetails'),
                logErrors: $config->get(key: 'error.logErrors'),
                logErrorDetails: $config->get(key: 'error.logErrorDetails'),
            );
        };
    }
}
