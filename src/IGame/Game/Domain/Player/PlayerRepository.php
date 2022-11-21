<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Player;

use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Shared\Domain\UserId;

interface PlayerRepository
{
    public function searchByUser(UserId $userId): ?Player;

    public function search(PlayerId $id): ?Player;

    public function searchByMoney(PrizeId $id): ?Player;
}