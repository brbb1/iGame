<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\MaterialObject;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Terms\TermsId;

interface MaterialObjectRepository
{
    public function search(PlayerId $playerId, PrizeId $id): ?MaterialObject;

    public function save(MaterialObject $prize): MaterialObject;

    /** @return MaterialObject[] */
    public function searchAvailable(TermsId $id): array;

    public function create(PlayerId $playerId, TermsId $termsId, MaterialObject $object): MaterialObject;

}