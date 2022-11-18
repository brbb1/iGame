<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Player\Find;

use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Query\QueryHandler;

class FindPlayerQueryHandler implements QueryHandler
{

    public function __construct(private readonly PlayerFinder $finder)
    {
    }

    public function __invoke(FindPlayerQuery $query): ?Player
    {
        $userId = new UserId($query->userId());
        $playerId = new PlayerId($query->playerId());

        return $this->finder->find($userId, $playerId);
    }
}