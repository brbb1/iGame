<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Application\Authenticate;

use Brbb\IGame\OAuth\Domain\AuthUser\AuthPassword;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthUser;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthUsername;
use Brbb\IGame\OAuth\Domain\AuthUser\InvalidAuthCredentials;
use Brbb\IGame\OAuth\Domain\AuthUser\InvalidAuthUsername;

final class UserAuthenticator
{
    public function __construct(private readonly AuthRepository $repository)
    {
    }

    public function authenticate(AuthUsername $username, AuthPassword $password): AuthUser
    {
        $auth = $this->repository->search($username);

        $this->ensureUserExist($auth, $username);
        /** @noinspection NullPointerExceptionInspection */
        $this->ensureCredentialsAreValid($auth, $password);

        return $auth;
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
