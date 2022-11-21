<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Shared\Domain\UserId;

class CreatePrizeCommandHandler
{

    public function __construct(private readonly PlayerFinder $playerFinder, private readonly PrizeCreator $creator)
    {
    }

    public function __invoke(CreatePrizeCommand $command): Prize
    {
        $userId = new UserId($command->userId());
        $drawId = new DrawId($command->drawId());

        $player = $this->playerFinder->findByUser($userId);

        return $this->creator->create($player->id(), $drawId);
    }
}