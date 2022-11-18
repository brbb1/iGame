<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Terms;

use RuntimeException;

final class NotFoundTerms extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Terms not created');
    }
}
