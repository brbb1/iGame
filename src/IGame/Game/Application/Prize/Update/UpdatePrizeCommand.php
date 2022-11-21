<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Update;

class UpdatePrizeCommand
{
    public function __construct(
        private readonly int    $userId,
        private readonly int    $prizeId,
        private readonly string $type,
        private readonly array  $data,
    )
    {
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function prizeId(): int
    {
        return $this->prizeId;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function status(): string
    {
        return $this->data['status'] ?? '';
    }
}