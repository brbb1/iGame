<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Draw;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Shared\Domain\UserId;

interface DrawRepository
{
    /** @return Draw[] */
    public function searchAll(PlayerId $playerId): array;
}