<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\IGame\Game\Domain\MaterialObject\MaterialObject;
use Brbb\IGame\Game\Domain\Money\Money;
use Brbb\IGame\Game\Domain\Points\Points;

enum Type: string
{
    case points = Points::class;
    case money = Money::class;
    case object = MaterialObject::class;
}
