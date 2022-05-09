<?php declare(strict_types=1);

namespace Map\Spillebord\Action\Site;

use Map\Spillebord\Action\BaseAction;
use Map\Spillebord\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeAction extends BaseAction
{
    /**
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function process(): ResponseInterface
    {
        return $this->returnView(template: 'app.twig');
    }
}
