<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\Points;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\SubjectId;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Primitives\Count;

class PrizeCreator
{

    public function create(UserId $userId, PlayerId $playerId, DrawId $drawId): ?Prize
    {
        return new Prize(new Points(new SubjectId(1111), new Count(10000)));
    }
}