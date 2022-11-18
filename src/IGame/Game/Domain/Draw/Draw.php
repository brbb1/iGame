<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Draw;

use Brbb\Shared\Domain\Primitives\Count;
use Brbb\Shared\Domain\Primitives\Name;
use Brbb\Shared\Domain\ValueObject\StringValueObject;

class Draw
{
    public function __construct(private readonly Name $name, private readonly Count $count)
    {
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
           'name' => $this->name(),
           'count' => $this->count(),
        ];
    }
}