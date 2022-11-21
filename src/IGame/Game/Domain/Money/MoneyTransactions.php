<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Money;

use Brbb\IGame\Game\Domain\Player\Player;

interface MoneyTransactions
{

    public function send(Player $player, Money $money): void;
}