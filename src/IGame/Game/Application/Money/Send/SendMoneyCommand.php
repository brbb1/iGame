<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Money\Send;

use Brbb\Shared\Domain\Command\Command;

class SendMoneyCommand implements Command
{
    public function __construct(private readonly int $count)
    {
    }

    public function count(): int
    {
        return $this->count;
    }
}