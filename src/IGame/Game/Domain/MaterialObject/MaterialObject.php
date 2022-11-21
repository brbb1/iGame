<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\MaterialObject;

use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\CantReplacePrize;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Type;
use Brbb\Shared\Domain\Primitives\Name;

class MaterialObject implements Prize
{
    public function __construct(
        private readonly PrizeId $id,
        private Status $status,
        private readonly Name $name,
        private readonly PlayerId $playerId
    )
    {
    }

    public function id(): PrizeId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function decline(): MaterialObject
    {
        $this->status = Status::Declined;

        return $this;
    }

    public function replace(): MaterialObject
    {
        throw new CantReplacePrize();
    }

    public function deliver(): MaterialObject
    {
        $this->status = Status::Declined;

        return $this;
    }

    public function toPrimitives(): array
    {
        return [
            'type' => Type::object->name,
            'id' => $this->id()->value(),
            'status' => $this->status()->value,
            'name' => $this->name()->value(),
        ];
    }
}