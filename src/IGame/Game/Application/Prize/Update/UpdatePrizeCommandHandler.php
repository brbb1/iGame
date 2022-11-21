<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Update;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Find\PrizeFinder;
use Brbb\IGame\Game\Domain\Prize\InvalidStatusType;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Prize\Type;
use Brbb\IGame\Game\Domain\Prize\InvalidPrizeType;
use Brbb\IGame\Shared\Domain\UserId;

class UpdatePrizeCommandHandler
{

    public function __construct(
        private readonly PlayerFinder       $playerFinder,
        private readonly PrizeFinder        $prizeFinder,
        private readonly PrizeStatusChanger $statusChanger,
    )
    {
    }

    public function __invoke(UpdatePrizeCommand $command): Prize
    {
        $userId = new UserId($command->userId());
        $player = $this->playerFinder->findByUser($userId);

        $prizeId = new PrizeId($command->prizeId());
        $nameType = [
            Type::money->name => Type::money,
            Type::points->name => Type::points,
            Type::object->name => Type::object,
        ];

        $type = $nameType[$command->type()] ?? null;
        if ($type === null) {
            throw new InvalidPrizeType();
        }

        $prize  = $this->prizeFinder->find($player->id(), $prizeId, $type);
        $nameStatus = [
            Status::Declined->value => Status::Declined,
            Status::Replaced->value => Status::Replaced,
        ];

        $status = $nameStatus[$command->status()] ?? null;
        if ($status === null) {
            throw new InvalidStatusType();
        }

        if ($status === Status::Declined) {
            return $this->statusChanger->decline($prize);
        }

        if ($status === Status::Replaced) {
            return $this->statusChanger->replace($prize);
        }

        return $prize;
    }
}