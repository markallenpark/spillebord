<?php

namespace Map\Spillebord;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

class Routes
{
    public static function create(App $route) : void
    {
        $route->get('/', function (
            ServerRequestInterface $request,
            ResponseInterface $response
        ) {
            $response->getBody()->write('Hello, world');
            return $response;
        });
    }
}