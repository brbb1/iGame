<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\Shared\Domain\Primitives\Count;

class Money implements Subject
{
    public function __construct(private readonly SubjectId $id, private readonly Count $count)
    {
    }

    public function id(): SubjectId
    {
        return $this->id;
    }

    public function count(): Count
    {
        return $this->count;
    }

    public function toPrimitives(): array
    {
        return [
            'type' => 'money',
            'id' => $this->id()->value(),
            'count' => $this->id()->value(),
        ];
    }
}