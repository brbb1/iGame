<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

class CreatePrizeCommand
{

    public function __construct(private readonly int $userId, private readonly int $drawId)
    {
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function drawId(): int
    {
        return $this->drawId;
    }
}