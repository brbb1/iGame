<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Prize;

use Brbb\IGame\Game\Application\Prize\Find\FindPrizesQuery;
use Brbb\IGame\Game\Application\Prize\Find\FindPrizesQueryHandler;
use Psr\Http\Message\ServerRequestInterface;

class PrizeGetController
{
    public function __construct(private readonly FindPrizesQueryHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId   = (int)($request->getParsedBody()['userId']);
        $drawId   = (int)$args['drawId'];

        $result = [];
        $prizes = $this->handler->__invoke(new FindPrizesQuery($userId, $drawId));
        foreach ($prizes as $prize) {
            $result[] = $prize->toPrimitives();
        }

        return $result;
    }
}