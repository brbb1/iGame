<?php

declare(strict_types=1);

namespace Brbb\Shared\Domain\ValueObject;

abstract class IdValueObject
{
    public function __construct(protected int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }
}
