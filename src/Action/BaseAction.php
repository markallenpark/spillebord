<?php declare(strict_types=1);

namespace Map\Spillebord\Action;

use Psr\Http\Message\ResponseInterface;

class BaseAction
{
    protected function asJson(ResponseInterface $response, array $data) : ResponseInterface
    {
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
