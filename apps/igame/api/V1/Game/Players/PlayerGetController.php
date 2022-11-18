<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Players;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\IGame\Game\Application\Player\Find\FindPlayerQuery;
use Brbb\IGame\Game\Application\Player\Find\FindPlayerQueryHandler;
use League\Container\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

final class PlayerGetController implements ControllerInterface
{
    public function __construct(private readonly FindPlayerQueryHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId = (int) $request->getParsedBody()['userId'];
        $playerId = (int) $args['playerId'];

        $player = $this->handler->__invoke(new FindPlayerQuery($userId, $playerId));
        if ($player === null) {
            throw new NotFoundException('Player not found');
        }

        return $player->toPrimitives();
    }
}