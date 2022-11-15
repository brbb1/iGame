<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface LaminasMiddlewareInterface extends MiddlewareInterface
{
    public function process(ServerRequest|ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}