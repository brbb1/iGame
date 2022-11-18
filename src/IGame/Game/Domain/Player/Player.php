<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Domain\Player;

use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Shared\Domain\Address;
use Brbb\IGame\Shared\Domain\BankAccount;
use Brbb\IGame\Shared\Domain\Coefficient;
use Brbb\IGame\Shared\Domain\UserId;
use Brbb\Shared\Domain\ValueObject\IntValueObject;
use Brbb\Shared\Domain\ValueObject\StringValueObject;

class Player
{
    /** @param Prize[] $prizes */
    public function __construct(
        private readonly PlayerId    $id,
        private readonly UserId      $userId,
        private readonly Grade       $grade,
        private readonly Coefficient $pointsCoefficient,
        private readonly BankAccount $bankAccount,
        private readonly Address     $address,
        private readonly array       $prizes,
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

    public function grade(): StringValueObject
    {
        return $this->grade;
    }

    public function pointsCoefficient(): IntValueObject
    {
        return $this->pointsCoefficient;
    }

    public function bankAccount(): StringValueObject
    {
        return $this->bankAccount;
    }

    public function address(): StringValueObject
    {
        return $this->address;
    }

    /** @return Prize[] */
    public function prizes(): array
    {
        return $this->prizes;
    }

    public function toPrimitives(): array
    {
        $prizes = [];
        foreach ($this->prizes as $prize) {
            $prizes[] = $prize->subject()->toPrimitives();
        }

        return [
            'playerId' => $this->id()->value(),
            'userid'   => $this->userid()->value(),
            'grade'    => $this->grade()->value(),
            'prizes'   => $prizes,
        ];
    }

}