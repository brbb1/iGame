<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Player;

use RuntimeException;

final class CantFindPlayer extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Can\'t find player');
    }
}
