<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Draws;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\IGame\Game\Application\Draw\Find\FindDrawsQuery;
use Brbb\IGame\Game\Application\Draw\Find\FindDrawsQueryHandler;
use Psr\Http\Message\ServerRequestInterface;

class DrawsGetController implements ControllerInterface
{

    public function __construct(private readonly FindDrawsQueryHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId = (int)$request->getParsedBody()['userId'];

        $draws = $this->handler->__invoke(new FindDrawsQuery($userId));

        $result = [];
        foreach ($draws as $draw) {
            $result[] = $draw->toPrimitives();
        }

        return $result;
    }
}