<?php declare(strict_types=1);

use Map\Spillebord\Config\Config;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return [
    'dependencies' => [
        Config::class,
        App::class,
        ErrorMiddleware::class,
        ResponseFactoryInterface::class,
        BasePathMiddleware::class,
    ]
];
