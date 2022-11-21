<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Money;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Points\Points;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Count;

interface MoneyRepository
{
    public function search(PlayerId $playerId, PrizeId $id): ?Money;

    public function save(Money $prize): Money;

    public function money(PlayerId $playerId, TermsId $termsId, Count $money): Money;

    public function replace(PrizeId $moneyId, PrizeId $prizeId): void;

    /** @return Points[] */
    public function searchAllByDraw(PlayerId $id, DrawId $drawId): array;
}