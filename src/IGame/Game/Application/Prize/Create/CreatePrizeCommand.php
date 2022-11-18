<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

class CreatePrizeCommand
{

    public function __construct(private readonly int $userId, private readonly int $playerId, private readonly int $drawId)
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

    public function drawId(): int
    {
        return $this->drawId;
    }
}