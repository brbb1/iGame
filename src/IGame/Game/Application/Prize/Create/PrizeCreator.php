<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\NotCreatedPrize;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeRepository;
use Brbb\IGame\Game\Domain\Prize\SubjectTypeMap;
use Brbb\IGame\Game\Domain\Terms\NotFoundTerms;
use Brbb\IGame\Game\Domain\Terms\Terms;
use Brbb\IGame\Game\Domain\Terms\TermsRepository;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\Primitives\Count;
use Contributte\Database\Transaction\Transaction;

class PrizeCreator
{
    public function __construct(
        private readonly Transaction     $transaction,
        private readonly PrizeRepository $prizeRepository,
        private readonly TermsRepository $termsRepository,
    )
    {
    }

    public function create(UserId $userId, PlayerId $playerId, DrawId $drawId): Prize
    {
        $this->transaction->begin();
        try {
            // Сначало ищем условия розыгрыша, если не нашли, значит пользователю они не доступны
            $terms = $this->termsRepository->search($userId, $playerId, $drawId);
            if ($terms === null) {
                throw new NotFoundTerms();
            }

            // На основе условий создаем массив для дольнейшего выбора какой приз создавать
            $pointsChance = $terms->pointsChance()->value();
            $moneyChance  = $terms->moneyChance()->value();
            $objectChance = $terms->objectChance()->value();

            $defaultPrize = [
                'count' => $terms->maxPoints()->value(),
                'type'  => SubjectTypeMap::POINTS,
            ];

            $prizes = [
                $pointsChance => $defaultPrize,

                $pointsChance + $moneyChance => [
                    'count' => $terms->budget()->value(),
                    'type'  => SubjectTypeMap::MONEY,
                ],

                $pointsChance + $moneyChance + $objectChance => [
                    'count' => $terms->objectChance()->value(),
                    'type'   => SubjectTypeMap::OBJECT,
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
                SubjectTypeMap::POINTS => $this->createPoints($playerId, $terms),
                SubjectTypeMap::MONEY => $this->createMoney($playerId, $terms),
                SubjectTypeMap::OBJECT => $this->createObject($playerId, $terms),
            };

            if ($prize === null) {
                throw new NotCreatedPrize();
            }
        } catch (NotFoundTerms $e){
            $this->transaction->rollback();

            throw $e;
        } catch (NotCreatedPrize|\Throwable $e) {
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

        return $this->prizeRepository->creatPointsPrize($playerId, $terms->id(), new Count($points));
    }

    public function createMoney(PlayerId $playerId, Terms $terms): Prize
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $money = random_int(1, $terms->budget()->value());

        return $this->prizeRepository->createMoneyPrize($playerId, $terms->id(), new Count($money));
    }

    public function createObject(PlayerId $playerId, Terms $terms): ?Prize
    {
        $objects = $this->prizeRepository->searchAvailableObjects($terms->id());

        if ($objects === []) {
            return null;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $object = $objects[random_int(0, count($objects) - 1)];

        return $this->prizeRepository->createObjectPrize($playerId, $terms->id(), $object);
    }
}