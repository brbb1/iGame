<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

interface Subject
{
    public function toPrimitives(): array;
}