<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Draw\Find;

use Brbb\IGame\Game\Domain\Draw\Draw;
use Brbb\IGame\Game\Domain\Draw\DrawRepository;
use Brbb\IGame\Game\Domain\Player\PlayerId;

class DrawFinder
{
    public function __construct(private readonly DrawRepository $repository)
    {
    }

    /** @return Draw[] */
    public function findAll(PlayerId $playerId): array
    {
        return $this->repository->searchAll($playerId);
    }
}