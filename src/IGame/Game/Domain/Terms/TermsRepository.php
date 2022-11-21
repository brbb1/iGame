<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Terms;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Shared\Domain\UserId;

interface TermsRepository
{
    public function search(PlayerId $playerId, DrawId $drawId): ?Terms;

    public function searchByMoney(PrizeId $id): ?Terms;
}