<?php

namespace Map\Spillebord;

use Slim\App;
use Slim\Middleware\ErrorMiddleware;

class Middleware
{
    public static function load(App $middleware) : void
    {
        $middleware->addBodyParsingMiddleware();
        $middleware->addRoutingMiddleware();
        $middleware->add(ErrorMiddleware::class);
    }
}
