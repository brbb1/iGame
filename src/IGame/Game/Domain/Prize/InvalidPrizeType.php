<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use RuntimeException;

final class InvalidPrizeType extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid prize type');
    }
}
