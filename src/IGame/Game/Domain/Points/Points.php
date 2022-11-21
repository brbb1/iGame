<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Points;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\NotReplacedPrize;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Type;
use Brbb\Shared\Domain\Primitives\Count;

class Points implements Prize
{
    public function __construct(
        private readonly PrizeId $id,
        private Status $status,
        private readonly Count $count,
        private readonly PlayerId $playerId,
    )
    {
    }

    public function id(): PrizeId
    {
        return $this->id;
    }

    public function count(): Count
    {
        return $this->count;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function decline(): Points
    {
       $this->status = Status::Declined;

        return $this;
    }

    public function replace(): Points
    {
        throw new NotReplacedPrize();
    }

    public function deliver(): Points
    {
        $this->status = Status::Declined;

        return $this;
    }

    public function toPrimitives(): array
    {
        return [
            'type' => Type::points->name,
            'id' => $this->id()->value(),
            'status' => $this->status()->value,
            'count' => $this->count()->value(),
        ];
    }
}