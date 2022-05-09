<?php

namespace Map\Spillebord\Middleware;

use Map\Spillebord\Factory\LoggerFactory;
use Monolog\Logger;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpException;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HttpExceptionMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private readonly ResponseFactoryInterface $responseFactory,
        private readonly Twig $twig,
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory->addFileHandler()->createLogger('HttpException');
    }

    /**
     * Process HTTP Errors
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle(request: $request);
        } catch (HttpException $httpException) {
            $statusCode = $httpException->getCode();
            $response = $this->responseFactory->createResponse()->withStatus($statusCode);

            $data = [
                'error' => [
                    'code' => $statusCode,
                    'message' => $response->getReasonPhrase(),
                    'uri' => $_SERVER['REQUEST_URI'],
                ]
            ];

            $template = ($this->twig->getLoader()->exists(name: 'error/' . $statusCode . '.twig')) ?
                'error/' . $statusCode . '.twig' :
                'error/generic.twig';

            // Only log for debugging purposes.
            $this->logger->debug('URI: ' . $data['error']['uri'] . ' MESSAGE: ' . $data['error']['message']);

            return $this->twig->render(
                response: $response,
                template: $template,
                data: $data
            );
        }
    }
}
