<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\IGame\Game\Domain\Player\PlayerId;

interface Prize
{
    public function playerId(): PlayerId;

    public function decline(): Prize;

    public function replace(): Prize;

    public function deliver(): Prize;

    public function startDeliver(): Prize;

    public function toPrimitives(): array;
}