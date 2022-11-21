<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Money\Send;

use Brbb\Shared\Domain\Command\CommandHandler;
use Brbb\Shared\Domain\Primitives\Count;

class SendMoneyCommandHandler implements CommandHandler
{
    public function __construct(private readonly MoneySender $moneySender)
    {
    }

    public function __invoke(SendMoneyCommand $command)
    {
        $this->moneySender->send(new Count($command->count()));
    }
}