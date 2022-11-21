<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Draw\Find;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Domain\Draw\Draw;
use Brbb\IGame\Shared\Domain\UserId;

class FindDrawsQueryHandler
{
    public function __construct(private readonly PlayerFinder $playerFinder, private readonly DrawFinder $finder)
    {
    }

    /** @return Draw[] */
    public function __invoke(FindDrawsQuery $query): array
    {
        $userId = new UserId($query->userId());
        $player = $this->playerFinder->findByUser($userId);

        return $this->finder->findAll($player->id());
    }

}