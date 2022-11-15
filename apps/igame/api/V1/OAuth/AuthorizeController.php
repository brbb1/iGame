<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\OAuth;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\IGame\OAuth\Application\Authenticate\AuthenticateUserCommand;
use Brbb\IGame\OAuth\Application\Authenticate\AuthenticateUserCommandHandler;
use Brbb\IGame\OAuth\Application\Authenticate\AuthResponse;
use Firebase\JWT\JWT;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorizeController implements ControllerInterface
{
    public function __construct(private readonly AuthenticateUserCommandHandler $handler, private readonly string $secretKey)
    {
    }

    /** @throws BadRequestException */
    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $body = $request->getParsedBody();

        $command = new AuthenticateUserCommand((string) $body['username'], (string) $body['password']);
        /** @var AuthResponse $response */
        $response = ($this->handler)($command);

        $payload = [
            'userId' => $response->getId()
        ];

        return ['token' => JWT::encode($payload, $this->secretKey, 'HS256')];
    }
}