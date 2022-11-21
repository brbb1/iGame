<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use RuntimeException;

final class WrongType extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Wrong prize type');
    }
}
