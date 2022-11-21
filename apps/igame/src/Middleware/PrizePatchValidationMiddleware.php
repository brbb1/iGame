<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Middleware;

use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PrizePatchValidationMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $bodyContents = $request->getBody()->getContents();
        try {
            $body = json_decode($bodyContents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new BadRequestException(sprintf('The json <%s> are invalid', $bodyContents));
        }

        $_POST['status'] = $body['status'];

        return $handler->handle(ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES));
    }
}