<?php

declare(strict_types=1);

namespace Brbb\IGame\OAuth\Application\Authenticate;

use Brbb\Shared\Domain\Command\Response;

class AuthResponse implements Response
{
    public function __construct(private readonly int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}