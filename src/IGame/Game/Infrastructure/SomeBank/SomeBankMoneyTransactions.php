<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Infrastructure\SomeBank;

use Brbb\IGame\Game\Domain\Money\Money;
use Brbb\IGame\Game\Domain\Money\MoneyTransactions;
use Brbb\IGame\Game\Domain\Player\Player;

class SomeBankMoneyTransactions implements MoneyTransactions
{

    public function send(Player $player, Money $money): void
    {
    }
}