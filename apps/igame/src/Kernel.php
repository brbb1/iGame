<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame;

use Brbb\Apps\IGame\Factory\Router\DefaultDispatcherFactory;
use Brbb\Apps\IGame\Http\HttpCode;
use Brbb\Apps\IGame\Http\Request\RequestInterface;
use Brbb\Apps\IGame\Http\Response\JsonErrorResponse;
use Brbb\Apps\IGame\Http\Response\ResponseInterface;
use FastRoute\Dispatcher;

class Kernel
{
    private Dispatcher $routeDispatcher;

    /** @throws \JsonException */
    public function __construct()
    {
        $projectDir = dirname(__DIR__);

        $this->routeDispatcher = DefaultDispatcherFactory::create((require $projectDir . '/config/routes.php')());
    }

    public function dispatch(RequestInterface $request): ResponseInterface
    {
        $routeInfo = $this->routeDispatcher->dispatch($request->getMethod(), $request->getUri());

        switch ($routeInfo[0]) {
            case Dispatcher::FOUND:
                // $routeInfo[1] contains handler class name
                $handler = new $routeInfo[1]();
                // $routeInfo[2] contains route variables
                $request->addData($routeInfo[2]);

                return $handler($request);
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new JsonErrorResponse(HttpCode::NOT_ALLOWED->value, 'Method not allowed');
            case Dispatcher::NOT_FOUND:
            default:
                return new JsonErrorResponse(HttpCode::NOT_FOUND->value, 'Resource not found');

        }
    }
}