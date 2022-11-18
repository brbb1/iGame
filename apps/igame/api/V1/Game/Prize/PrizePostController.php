<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Prize;

use Brbb\IGame\Game\Application\Prize\Create\CreatePrizeCommand;
use Brbb\IGame\Game\Application\Prize\Create\CreatePrizeCommandHandler;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class PrizePostController
{
    public function __construct(private readonly CreatePrizeCommandHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId = (int) ($request->getParsedBody()['userId']);
        $playerId = (int) $args['playerId'];
        $drawId = (int) $args['drawId'];

        $prize = $this->handler->__invoke(new CreatePrizeCommand($userId, $playerId, $drawId));
        if ($prize === null) {
            throw new NotFoundException('Can\'t create prize');
        }

        return $prize->toPrimitives();
    }

}