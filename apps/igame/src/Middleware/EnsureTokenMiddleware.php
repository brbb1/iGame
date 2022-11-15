<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EnsureTokenMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly string $secretKey)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaders()['authorization'] ?? null;
        if ($token === null) {
            throw new UnauthorizedException('Token is not found');
        }

        $token = substr($token[0], strlen('Bearer '));
        try {
            $decode = JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            throw new UnauthorizedException('Token is not valid');
        }

        $_POST['userId'] = $decode->userId;

        return $handler->handle(ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES));
    }
}