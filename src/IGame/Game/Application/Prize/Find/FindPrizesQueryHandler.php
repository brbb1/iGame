<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Find;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Query\QueryHandler;

class FindPrizesQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly PlayerFinder $playerFinder,
        private readonly PrizeFinder  $prizeFinder,
    )
    {
    }

    /** @return Prize[] */
    public function __invoke(FindPrizesQuery $query): array
    {
        $userId = new UserId($query->userId());
        $drawId = new DrawId($query->drawId());

        $player = $this->playerFinder->findByUser($userId);

        return $this->prizeFinder->findAll($player->id(), $drawId);
    }
}