<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Terms;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Shared\Domain\UserId;

interface TermsRepository
{
    public function search(UserId $userId, PlayerId $playerId, DrawId $drawId): ?Terms;
}