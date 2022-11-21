<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Points;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Count;

interface PointsRepository
{
    public function search(PlayerId $playerId, PrizeId $id): ?Points;

    public function save(Points $prize): Points;

    public function create(PlayerId $playerId, TermsId $termsId, Count $points): Points;
}