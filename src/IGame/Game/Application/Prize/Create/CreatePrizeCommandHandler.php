<?php

declare(strict_types=1);

namespace Brbb\IGame\Game\Application\Prize\Create;

use Brbb\IGame\Game\Domain\Draw\DrawId;
use Brbb\IGame\Game\Domain\Player\PlayerId;
use Brbb\IGame\Game\Domain\Prize\Prize;
use Brbb\IGame\Shared\Domain\UserId;

class CreatePrizeCommandHandler
{

    public function __construct(private readonly PrizeCreator $creator)
    {
    }

    public function __invoke(CreatePrizeCommand $command): Prize
    {
        $userId = new UserId($command->userId());
        $playerId = new PlayerId($command->playerId());
        $drawId = new DrawId($command->drawId());

        return $this->creator->create($userId, $playerId, $drawId);
    }
}