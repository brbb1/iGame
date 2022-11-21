<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Player;

class PlayerIdNull extends PlayerId
{
    public function value(): int
    {
        throw new CantFindPlayer();
    }
}