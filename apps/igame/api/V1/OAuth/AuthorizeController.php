<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\OAuth;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\IGame\OAuth\Application\Authenticate\AuthenticateUserCommand;
use Brbb\IGame\OAuth\Application\Authenticate\AuthenticateUserCommandHandler;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;

final class AuthorizeController implements ControllerInterface
{
    public function __construct(private readonly AuthenticateUserCommandHandler $handler)
    {
    }

    /** @throws BadRequestException */
    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $bodyContents = $request->getBody()->getContents();
        try {
            $body = json_decode($bodyContents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new BadRequestException(sprintf('The json <%s> are invalid', $bodyContents));
        }

        $command = new AuthenticateUserCommand((string) $body['username'], (string) $body['password']);
        $response = ($this->handler)($command);

        return ['token' => $response->getToken()];
    }
}