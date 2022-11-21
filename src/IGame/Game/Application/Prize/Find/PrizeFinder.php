<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Find;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\MaterialObject\MaterialObjectRepository;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Points\PointsRepository;
use Brbb\IGame\Game\Domain\Prize\CantFoundPrize;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Type;

class PrizeFinder
{
    public function __construct(
        private readonly PointsRepository         $pointsRepository,
        private readonly MoneyRepository          $moneyRepository,
        private readonly MaterialObjectRepository $objectRepository,
    )
    {
    }

    public function find(PlayerId $playerId, PrizeId $prizeId, Type $type): Prize
    {
        $prize = match ($type) {
            Type::points => $this->pointsRepository->search($playerId, $prizeId),
            Type::money => $this->moneyRepository->search($playerId, $prizeId),
            Type::object => $this->objectRepository->search($playerId, $prizeId),
        };

        if ($prize === null) {
            throw new CantFoundPrize();
        }

        return $prize;
    }

    /** @return Prize[] */
    public function findAll(PlayerId $id, DrawId $drawId): array
    {
        $points = $this->pointsRepository->searchAllByDraw($id, $drawId);
        $money = $this->moneyRepository->searchAllByDraw($id, $drawId);
        $objects = $this->objectRepository->searchAllByDraw($id, $drawId);

        return array_merge($points, $money, $objects);
    }
}