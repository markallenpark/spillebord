<?php declare(strict_types=1);

namespace Map\Spillebord\Middleware;

use Map\Spillebord\Factory\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param LoggerFactory $loggerFactory
     */
    public function __construct(LoggerFactory $loggerFactory) {
        $this->logger = $loggerFactory
            ->addFileHandler()
            ->createLogger(name: 'PhpError');
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $errorTypes = E_ALL;

        set_error_handler(
            function (
                $errorNumber,
                $errorString,
                $errorFile,
                $errorLine
            ) {
                $message = "Error number [$errorNumber] $errorString on line $errorLine in file $errorFile";

                switch ($errorNumber) {
                    case E_USER_ERROR:
                        $this->logger->error(message: $message);
                        break;
                    case E_USER_WARNING:
                        $this->logger->warning(message: $message);
                        break;
                    default:
                        $this->logger->notice(message: $message);
                        break;
                }

                return true; // don't execute internal PHP handler
            },
            $errorTypes
        );

        return $handler->handle(request: $request);
    }
}
