<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\Shared\Domain\Primitives\Name;

class MaterialObject implements Subject
{
    public function __construct(private readonly SubjectId $id, private readonly Status $status, private readonly Name $name)
    {
    }

    public function id(): SubjectId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
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
            'name' => $this->name()->value(),
        ];
    }
}