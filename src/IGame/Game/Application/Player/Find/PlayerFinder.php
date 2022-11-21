<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Player\Find;

use Brbb\IGame\Game\Domain\Player\NotFoundPlayer;
use Brbb\IGame\Game\Domain\Player\Player;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Shared\Domain\UserId;

class PlayerFinder
{
    public function __construct(private readonly PlayerRepository $repository)
    {
    }

    public function findByUser(UserId $userId): Player
    {
        $player = $this->repository->searchByUser($userId);
        if ($player === null) {
            throw new NotFoundPlayer();
        }

        return $player;
    }

    public function find(PlayerId $id): Player
    {
        $player = $this->repository->search($id);
        if ($player === null) {
            throw new NotFoundPlayer();
        }

        return $player;
    }
}