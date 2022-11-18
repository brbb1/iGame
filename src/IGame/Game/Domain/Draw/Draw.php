<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Draw;

use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;

class Draw
{
    public function __construct(private readonly DrawId $id, private readonly Name $name, private readonly Count $count)
    {
    }

    public function id(): DrawId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function count(): Count
    {
        return $this->count;
    }

    public function toPrimitives(): array
    {
        return [
            'id'    => $this->id()->value(),
            'name'  => $this->name()->value(),
            'count' => $this->count()->value(),
        ];
    }
}