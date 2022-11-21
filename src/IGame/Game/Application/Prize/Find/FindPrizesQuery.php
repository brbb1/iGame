<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Find;

use Brbb\Shared\Domain\Query\QueryHandler;

class FindPrizesQuery implements QueryHandler
{

    public function __construct(
        private readonly int $userId,
        private readonly int $drawId,
    )
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