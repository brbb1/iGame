<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

class MoneyPrize
{

    public function __construct(private readonly PrizeId $id)
    {
    }

    public function id(): PrizeId
    {
        return $this->id;
    }
}