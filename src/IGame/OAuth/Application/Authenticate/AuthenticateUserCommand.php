<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Application\Authenticate;

use Brbb\Shared\Domain\Command\Command;

final class AuthenticateUserCommand implements Command
{
    public function __construct(private readonly string $username, private readonly string $password)
    {
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }
}
