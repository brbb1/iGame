<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Update;

use Brbb\IGame\Game\Application\Prize\Create\PrizeCreator;
use Brbb\IGame\Game\Domain\MaterialObject\MaterialObjectRepository;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Points\PointsRepository;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\ReplacePrize;
use Brbb\IGame\Game\Domain\Prize\Type;
use Contributte\Database\Transaction\Transaction;

class PrizeStatusChanger
{

    public function __construct(
        private readonly Transaction              $transaction,
        private readonly PointsRepository         $pointsRepository,
        private readonly MoneyRepository          $moneyRepository,
        private readonly MaterialObjectRepository $objectRepository,
        private readonly PrizeCreator             $prizeCreator
    )
    {
    }

    public function decline(Prize $prize): Prize
    {
        return $this->save($prize->decline());
    }

    public function replace(Prize $prize): Prize
    {
        $prize = $prize->replace();

        $this->transaction->begin();
        try {
            $this->save($prize);

            if ($prize::class === Type::money->value) {
                /** @noinspection PhpParamsInspection */
                $points = $this->prizeCreator->createPointsByMoney($prize);
            }
        } catch (\Throwable $e) {
            $this->transaction->rollback();

            throw new ReplacePrize();
        }

        $this->transaction->commit();

        return $prize;
    }

    private function save(Prize $prize): Prize
    {
        if ($prize::class === Type::points->value) {
            /** @noinspection PhpParamsInspection */
            return $this->pointsRepository->save($prize);
        }

        if ($prize::class === Type::object->value) {
            /** @noinspection PhpParamsInspection */
            return $this->objectRepository->save($prize);
        }

        if ($prize::class === Type::money->value) {
            /** @noinspection PhpParamsInspection */
            return $this->moneyRepository->save($prize);
        }

        return $prize;
    }
}