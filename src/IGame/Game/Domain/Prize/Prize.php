<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Prize;

class Prize
{

    public function __construct(private readonly Subject $subject)
    {
    }

    public function subject(): Subject
    {
        return $this->subject;
    }

    public function toPrimitives(): array
    {
        return $this->subject->toPrimitives();
    }

}