<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Infrastructure\Persistence;

use Brbb\IGame\OAuth\Domain\AuthUser\AuthId;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthPassword;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthUser;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthUsername;
use Nette\Database\Connection;

final class MySqlAuthRepository implements AuthRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function search(AuthUsername $username): ?AuthUser
    {
        $users = $this->connection->query('SELECT id, name, password FROM users WHERE name = ?', $username->value());
        /** @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($users as $user) {
            return new AuthUser(
                new AuthId((int)$user->id),
                new AuthUsername((string)$user->name),
                new AuthPassword((string)$user->password)
            );
        }

        return null;
    }
}
