<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Application\Authenticate;

use Brbb\IGame\OAuth\Domain\AuthPassword;
use Brbb\IGame\OAuth\Domain\AuthUsername;
use Brbb\Shared\Domain\Command\CommandHandler;

final class AuthenticateUserCommandHandler implements CommandHandler
{
    public function __construct(private readonly UserAuthenticator $authenticator)
    {
    }

    public function __invoke(AuthenticateUserCommand $command): AuthResponse
    {
        $username = new AuthUsername($command->username());
        $password = new AuthPassword($command->password());

        $authUser = $this->authenticator->authenticate($username, $password);

        return new AuthResponse($authUser->id()->value());
    }
}
