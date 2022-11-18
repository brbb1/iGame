<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Player\Find;

use Brbb\IGame\Game\Domain\Player\NotFindPlayer;
use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Shared\Domain\UserId;

class PlayerFinder
{
    public function __construct(private readonly PlayerRepository $repository)
    {
    }

    public function find(UserId $userId, PlayerId $playerId): Player
    {
        $player = $this->repository->search($userId, $playerId);
        if ($player === null) {
            throw new NotFindPlayer();
        }

        return $player;
    }
}