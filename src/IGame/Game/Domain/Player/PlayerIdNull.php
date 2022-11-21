<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Player;

use Brbb\Shared\Domain\ValueObject\IdValueObject;

class PlayerIdNull extends PlayerId
{
    public function value(): int
    {
        throw new NotFoundPlayer();
    }
}