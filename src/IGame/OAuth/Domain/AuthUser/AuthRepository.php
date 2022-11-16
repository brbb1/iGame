<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Domain\AuthUser;

interface AuthRepository
{
    public function search(AuthUsername $username): ?AuthUser;
}
