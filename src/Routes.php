<?php declare(strict_types=1);

namespace Map\Spillebord;

use Map\Spillebord\Action\Site\HomeAction;
use Slim\App;

class Routes
{
    public static function create(App $route) : void
    {
        $route->get(pattern: '/', callable: HomeAction::class)->setName(name: 'home');
    }
}
