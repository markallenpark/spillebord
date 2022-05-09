<?php declare(strict_types=1);

use Map\Spillebord\Config\Config;
use Map\Spillebord\Factory\LoggerFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return [
    'dependencies' => [
        App::class,
        BasePathMiddleware::class,
        Config::class,
        ErrorMiddleware::class,
        LoggerFactory::class,
        ResponseFactoryInterface::class,
        Twig::class,
        TwigMiddleware::class,
    ]
];
