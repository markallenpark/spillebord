<?php

use Map\Spillebord\Config\Config;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return [
    'dependencies' => [
        Config::class,
        App::class,
        ErrorMiddleware::class,
    ]
];
