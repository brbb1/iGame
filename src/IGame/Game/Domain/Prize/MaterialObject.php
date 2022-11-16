<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

use Brbb\Shared\Domain\Primitives\Name;

class MaterialObject implements Subject
{
    public function __construct(private readonly SubjectId $id, private readonly Name $name)
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


    public function toPrimitives(): array
    {
        return [
            'type' => 'material_object',
            'id' => $this->id()->value(),
            'name' => $this->id()->value(),
        ];
    }
}