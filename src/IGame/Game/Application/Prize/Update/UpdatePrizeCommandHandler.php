<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Update;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Find\PrizeFinder;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Game\Domain\Prize\PrizeId;
use Brbb\IGame\Game\Domain\Prize\Status;
use Brbb\IGame\Game\Domain\Prize\Type;
use Brbb\IGame\Game\Domain\Prize\WrongType;
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
        $type    = Type::tryFrom($command->type());
        if ($type === null) {
            throw new WrongType();
        }

        $prize  = $this->prizeFinder->find($player->id(), $prizeId, $type);
        $status = Status::tryFrom($command->status());

        if ($status === Status::Declined) {
            return $this->statusChanger->decline($prize);
        }

        if ($status === Status::Replaced) {
            return $this->statusChanger->replace($prize);
        }

        return $prize;
    }
}