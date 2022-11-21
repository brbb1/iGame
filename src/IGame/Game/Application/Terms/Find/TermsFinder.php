<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Terms\Find;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Money\Money;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Terms\Terms;
use Brbb\IGame\Game\Domain\Terms\TermsRepository;

class TermsFinder
{
    public function __construct(private readonly TermsRepository $repository)
    {
    }

    public function find(PlayerId $playerId, DrawId $drawId): ?Terms
    {
        return $this->repository->search($playerId, $drawId);
    }

    public function findByMoney(Money $prize): Terms
    {
        return $this->repository->searchByMoney($prize->id());
    }
}