<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Money\Send;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Update\PrizeStatusChanger;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Money\MoneyTransactions;
use Brbb\Shared\Domain\Primitives\Count;

class MoneySender
{
    public function __construct(
        private readonly MoneyRepository $moneyRepository,
        private readonly PlayerFinder    $playerFinder,
        private readonly PrizeStatusChanger $prizeStatusChanger,
        private readonly MoneyTransactions $moneyTransactions,
    )
    {
    }

    public function send(Count $count): void
    {
        $moneys = $this->moneyRepository->searchForSend($count);

        foreach ($moneys as $money) {
            try {
                $player = $this->playerFinder->findByMoney($money->id());
                $this->prizeStatusChanger->deliver($money);

                $this->moneyTransactions->send($player, $money);
            } catch (\Exception $e) {
                $this->prizeStatusChanger->startDeliver($money);
            }
        }
    }
}