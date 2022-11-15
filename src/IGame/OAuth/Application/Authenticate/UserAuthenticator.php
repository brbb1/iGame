<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Application\Authenticate;

use Brbb\IGame\OAuth\Domain\AuthPassword;
use Brbb\IGame\OAuth\Domain\AuthRepository;
use Brbb\IGame\OAuth\Domain\AuthUser;
use Brbb\IGame\OAuth\Domain\AuthUsername;
use Brbb\IGame\OAuth\Domain\InvalidAuthCredentials;
use Brbb\IGame\OAuth\Domain\InvalidAuthUsername;

final class UserAuthenticator
{
    public function __construct(private readonly AuthRepository $repository)
    {
    }

    public function authenticate(AuthUsername $username, AuthPassword $password): void
    {
        $auth = $this->repository->search($username);

        $this->ensureUserExist($auth, $username);
        /** @noinspection NullPointerExceptionInspection */
        $this->ensureCredentialsAreValid($auth, $password);
    }

    private function ensureUserExist(?AuthUser $auth, AuthUsername $username): void
    {
        if (null === $auth) {
            throw new InvalidAuthUsername($username);
        }
    }

    private function ensureCredentialsAreValid(AuthUser $auth, AuthPassword $password): void
    {
        if (!$auth->passwordMatches($password)) {
            throw new InvalidAuthCredentials($auth->username());
        }
    }
}
