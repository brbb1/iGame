<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\Shared\Domain\Primitives\Count;

class Money implements Subject
{
    public function __construct(private readonly SubjectId $id, private readonly Status $status, private readonly Count $count)
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

    public function status(): Status
    {
        return $this->status;
    }

    public function toPrimitives(): array
    {
        return [
            'type' => SubjectTypeMap::SUBJECT_TYPE[self::class],
            'id' => $this->id()->value(),
            'status' => $this->status()->value,
            'count' => $this->count()->value(),
        ];
    }
}