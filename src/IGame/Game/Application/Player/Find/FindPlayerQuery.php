<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Player\Find;

use Brbb\Shared\Domain\Query\Query;

class FindPlayerQuery implements Query
{

    public function __construct(private readonly int $userId)
    {
    }

    public function userId(): int
    {
        return $this->userId;
    }
}