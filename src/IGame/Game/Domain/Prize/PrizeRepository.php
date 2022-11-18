<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Terms\TermsId;
use Brbb\Shared\Domain\Primitives\Count;

interface PrizeRepository
{

    /** @return MaterialObject[] */
    public function searchAvailableObjects(TermsId $id): array;

    public function creatPointsPrize(PlayerId $playerId, TermsId $termsId, Count $points): Prize;

    public function createMoneyPrize(PlayerId $playerId, TermsId $termsId, Count $money): Prize;

    public function createObjectPrize(PlayerId $playerId, TermsId $termsId, MaterialObject $object): Prize;
}