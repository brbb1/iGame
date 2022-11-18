<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Terms;

use Brbb\IGame\Shared\Domain\Chance;
use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;

class Terms
{

    public function __construct(
        private readonly TermsId $id,
        private readonly Name    $name,
        private readonly Chance  $pointsChance,
        private readonly Count   $maxPoints,
        private readonly Chance  $moneyChance,
        private readonly Count   $budget,
        private readonly Chance  $objectChance,
        private readonly Count   $objectCount,
    )
    {
    }

    public function id(): TermsId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function pointsChance(): Chance
    {
        return $this->pointsChance;
    }

    public function maxPoints(): Count
    {
        return $this->maxPoints;
    }

    public function moneyChance(): Chance
    {
        return $this->moneyChance;
    }

    public function budget(): Count
    {
        return $this->budget;
    }

    public function objectChance(): Chance
    {
        return $this->objectChance;
    }

    public function objectCount(): Count
    {
        return $this->objectCount;
    }
}