<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Middleware;

use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthorizeValidationMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $bodyContents = $request->getBody()->getContents();
        try {
            $body = json_decode($bodyContents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new BadRequestException(sprintf('The json <%s> are invalid', $bodyContents));
        }

        if (!isset($body['username']) || !is_string($body['username']) || strlen($body['username']) > 255) {
            throw new BadRequestException(sprintf('The username <%s> are invalid', $body['username']));
        }

        if (!isset($body['password']) || !is_string($body['password']) || strlen($body['password']) > 255) {
            throw new BadRequestException(sprintf('The password <%s> are invalid', $body['password']));
        }

        $_POST['username'] = $body['username'];
        $_POST['password'] = $body['password'];

        return $handler->handle(ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES));
    }
}