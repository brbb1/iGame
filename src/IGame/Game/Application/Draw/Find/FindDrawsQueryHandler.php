<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Draw\Find;

use Brbb\IGame\Game\Domain\Draw\Draw;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Shared\Domain\UserId;

class FindDrawsQueryHandler
{
    public function __construct(private readonly DrawFinder $finder)
    {
    }

    /** @return Draw[] */
    public function __invoke(FindDrawsQuery $query): array
    {
        $userId = new UserId($query->userId());
        $playerId = new PlayerId($query->playerId());

        return $this->finder->findAll($userId, $playerId);
    }

}