<?php declare(strict_types=1);

namespace Map\Spillebord\Action\Site;

use Map\Spillebord\Action\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction extends BaseAction
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ) : ResponseInterface
    {
        $response->getBody()->write(string: 'Hello, world');
        return $response;
    }
}
