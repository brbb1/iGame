<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Players;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\IGame\Game\Application\Player\Find\FindPlayerQuery;
use Brbb\IGame\Game\Application\Player\Find\FindPlayerQueryHandler;
use Psr\Http\Message\ServerRequestInterface;

final class PlayerGetController implements ControllerInterface
{
    public function __construct(private readonly FindPlayerQueryHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId = (int) $request->getParsedBody()['userId'];

        return $this->handler->__invoke(new FindPlayerQuery($userId))->toPrimitives();
    }
}