<?php declare(strict_types=1);

use Map\Spillebord\Config\Config;
use Map\Spillebord\Factory\LoggerFactory;
use Odan\Session\Middleware\SessionMiddleware;
use Odan\Session\SessionInterface;
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
        SessionInterface::class,
        SessionMiddleware::class,
        Twig::class,
        TwigMiddleware::class,
        PDO::class,
    ]
];
