<?php declare(strict_types=1);

use Map\Spillebord\Config\Config;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return [
    'dependencies' => [
        Config::class,
        App::class,
        ErrorMiddleware::class,
        ResponseFactoryInterface::class,
        BasePathMiddleware::class,
        Twig::class,
        TwigMiddleware::class
    ]
];
