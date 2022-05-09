<?php declare(strict_types=1);

namespace Map\Spillebord;

use Map\Spillebord\Middleware\ErrorHandlerMiddleware;
use Map\Spillebord\Middleware\HttpExceptionMiddleware;
use Odan\Session\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

class Middleware
{
    public static function load(App $middleware) : void
    {
        $middleware->addBodyParsingMiddleware();
        $middleware->add(middleware: TwigMiddleware::class);
        $middleware->add(middleware: SessionMiddleware::class);
        $middleware->addRoutingMiddleware();
        $middleware->add(middleware: HttpExceptionMiddleware::class);
        $middleware->add(middleware: ErrorHandlerMiddleware::class);
        $middleware->add(middleware: ErrorMiddleware::class);
    }
}
