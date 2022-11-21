<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Draw\Find;

class FindDrawsQuery
{

    public function __construct(private readonly int $userId)
    {
    }

    public function userId(): int
    {
        return $this->userId;
    }
}