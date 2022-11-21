<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Terms\Find\TermsFinder;
use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\MaterialObject\MaterialObjectRepository;
use Brbb\IGame\Game\Domain\Money\Money;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Points\Points;
use Brbb\IGame\Game\Domain\Points\PointsRepository;
use Brbb\IGame\Game\Domain\Prize\CantCreatePrize;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\Type;
use Brbb\IGame\Game\Domain\Terms\NotFoundTerms;
use Brbb\IGame\Game\Domain\Terms\Terms;
use Brbb\Shared\Domain\Primitives\Count;
use Contributte\Database\Transaction\Transaction;

class PrizeCreator
{
    public function __construct(
        private readonly Transaction              $transaction,
        private readonly PlayerFinder             $playerFinder,
        private readonly TermsFinder              $termsFinder,
        private readonly PointsRepository         $pointsRepository,
        private readonly MoneyRepository          $moneyRepository,
        private readonly MaterialObjectRepository $objectRepository,
    )
    {
    }

    public function create(PlayerId $playerId, DrawId $drawId): Prize
    {
        // Сначало ищем условия розыгрыша, если не нашли, значит пользователю они не доступны
        $terms = $this->termsFinder->find($playerId, $drawId);
        if ($terms === null) {
            throw new NotFoundTerms();
        }

        $this->transaction->begin();
        try {
            // На основе условий создаем массив для выбора какой приз создавать
            $pointsChance = $terms->pointsChance()->value();
            $moneyChance  = $terms->moneyChance()->value();
            $objectChance = $terms->objectChance()->value();

            $defaultPrize = [
                'count' => $terms->maxPoints()->value(),
                'type'  => Type::points,
            ];

            $prizes = [
                $pointsChance => $defaultPrize,

                $pointsChance + $moneyChance => [
                    'count' => $terms->budget()->value(),
                    'type'  => Type::money,
                ],

                $pointsChance + $moneyChance + $objectChance => [
                    'count' => $terms->objectChance()->value(),
                    'type'  => Type::object,
                ],
            ];

            // Розынрыш приза
            /** @noinspection PhpUnhandledExceptionInspection */
            $percent = random_int(0, 99);

            // Если все деньги или вещи были уже разыграны, начисляем очки
            $validPrize = $defaultPrize;
            foreach ($prizes as $prizePercent => $prize) {
                if ($percent >= $prizePercent) {
                    continue;
                }

                if ($prize['count'] === 0) {
                    break;
                }

                $validPrize = $prize;
                break;
            }

            // Вызываем функцию создания приза
            $prize = match ($validPrize['type']) {
                Type::points => $this->createPoints($playerId, $terms),
                Type::money => $this->createMoney($playerId, $terms),
                Type::object => $this->createObject($playerId, $terms),
            };

            if ($prize === null) {
                throw new CantCreatePrize();
            }
        } catch (NotFoundTerms $e) {
            $this->transaction->rollback();

            throw $e;
        } catch (CantCreatePrize|\Throwable $e) {
            // Если произошла ошибка, разыгрываем очки
            $this->transaction->rollback();

            return $this->createPoints($playerId, $terms);
        }

        $this->transaction->commit();

        return $prize;
    }

    public function createPoints(PlayerId $playerId, Terms $terms): Prize
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $points = random_int(1, $terms->maxPoints()->value());

        return $this->pointsRepository->create($playerId, $terms->id(), new Count($points));
    }

    public function createMoney(PlayerId $playerId, Terms $terms): Prize
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $money = random_int(1, $terms->budget()->value());

        return $this->moneyRepository->money($playerId, $terms->id(), new Count($money));
    }

    public function createObject(PlayerId $playerId, Terms $terms): ?Prize
    {
        $objectsIds = $this->objectRepository->searchAvailable($terms->id());
        if ($objectsIds === []) {
            return null;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $objectId = $objectsIds[random_int(0, count($objectsIds) - 1)];

        return $this->objectRepository->create($playerId, $terms->id(), $objectId);
    }

    public function createPointsByMoney(Money $prize): Points
    {
        $player = $this->playerFinder->find($prize->playerId());
        $terms  = $this->termsFinder->findByMoney($prize);

        $count = new Count($prize->count()->multiply($player->pointsCoefficient()));

        $points = $this->pointsRepository->create($player->id(), $terms->id(), $count);
        $this->moneyRepository->replace($prize->id(), $points->id());

        return $points;
    }
}