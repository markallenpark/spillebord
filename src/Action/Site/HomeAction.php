<?php declare(strict_types=1);

namespace Map\Spillebord\Action\Site;

use Map\Spillebord\Action\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction extends BaseAction
{
    protected function process(): ResponseInterface
    {
        return $this->returnView(template: 'app.twig');
    }
}
