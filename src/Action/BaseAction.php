<?php declare(strict_types=1);

namespace Map\Spillebord\Action;

use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BaseAction
{
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;
    protected array $args;

    /**
     * Inject dependencies
     *
     * @param Twig $twig
     * @param SessionInterface $session
     */
    public function __construct(
        protected Twig $twig,
        protected SessionInterface $session
    ) {
        // Intentionally blank
    }

    /**
     * Prepare our data for processing
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ) : ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;

        return $this->process();
    }

    /**
     * Get information about current route
     *
     * @return array
     */
    protected function routeInfo() : array
    {
        $routeContext = RouteContext::fromRequest($this->request);
        $route = $routeContext->getRoute();

        return [
            'name' => $route->getName(),
            'groups' => $route->getGroups(),
            'methods' => $route->getMethods(),
            'arguments' => $route->getArguments(),
        ];
    }

    /**
     * Process data before returning response.
     *
     * @return ResponseInterface
     */
    protected function process(): ResponseInterface
    {
        // Default action is to just return the response - This way if we do nothing,
        // the application doesn't break
        return $this->response;
    }

    /**
     * Respond with a Twig template
     *
     * @param string $template
     * @param array $viewData
     * @return ResponseInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function returnView(
        string $template,
        array $viewData = []) : ResponseInterface
    {
        $viewData['route'] = $this->routeInfo();

        return $this->twig->render(
            response: $this->response,
            template: $template,
            data: $viewData
        );
    }

    /**
     * Respond with JSON
     *
     * @param array $data
     * @return ResponseInterface
     */
    protected function returnJson(array $data) : ResponseInterface
    {
        $this->response->getBody()->write(json_encode($data));
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
