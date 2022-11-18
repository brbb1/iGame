<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Draws;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\IGame\Game\Application\Draw\FindDrawsQueryHandler;
use Brbb\IGame\Game\Application\Draw\FindDrawsQuery;
use Psr\Http\Message\ServerRequestInterface;

class DrawsGetController implements ControllerInterface
{

    public function __construct(private readonly FindDrawsQueryHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId   = (int)($request->getParsedBody()['userId'] ?? 1);
        $playerId = (int)($args['id'] ?? 1);

        $draws = $this->handler->__invoke(new FindDrawsQuery($userId, $playerId));

        $result = [];
        foreach ($draws as $draw) {
            $result[] = $draw->toPrimitives();
        }

        return $result;
    }
}