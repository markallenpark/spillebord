<?php declare(strict_types=1);

namespace Map\Spillebord;

use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

class Middleware
{
    public static function load(App $middleware) : void
    {
        $middleware->addBodyParsingMiddleware();
        $middleware->add(middleware: TwigMiddleware::class);
        $middleware->addRoutingMiddleware();
        $middleware->add(middleware: ErrorMiddleware::class);
    }
}
