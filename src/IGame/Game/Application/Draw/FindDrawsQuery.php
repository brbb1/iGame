<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Draw;

class FindDrawsQuery
{

    public function __construct(private readonly int $userId, private readonly int $playerId)
    {
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function playerId(): int
    {
        return $this->playerId;
    }
}