<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Prize;

use Brbb\IGame\Game\Application\Prize\Create\CreatePrizeCommand;
use Brbb\IGame\Game\Application\Prize\Create\CreatePrizeCommandHandler;
use Psr\Http\Message\ServerRequestInterface;

class PrizePostController
{
    public function __construct(private readonly CreatePrizeCommandHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId   = (int)($request->getParsedBody()['userId']);
        $drawId   = (int)$args['drawId'];

        return ($this->handler->__invoke(new CreatePrizeCommand($userId, $drawId)))->toPrimitives();
    }
}