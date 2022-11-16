<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Player;

use Brbb\IGame\Shared\Domain\UserId;

class Player
{
    public function __construct(
        private readonly PlayerId $id,
        private readonly UserId $userId,
    )
    {
    }

    public function id(): PlayerId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}