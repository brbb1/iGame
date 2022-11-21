<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Prize;

use Brbb\IGame\Game\Application\Prize\Update\UpdatePrizeCommand;
use Brbb\IGame\Game\Application\Prize\Update\UpdatePrizeCommandHandler;
use Psr\Http\Message\ServerRequestInterface;

class PrizePatchController
{
    public function __construct(private readonly UpdatePrizeCommandHandler $handler)
    {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        $userId   = (int)$request->getParsedBody()['userId'];
        $prizeId  = (int)$args['id'];
        $type     = (string)$args['prizeType'];

        $patchData = $request->getParsedBody();

        return ($this->handler->__invoke(
            new UpdatePrizeCommand($userId, $prizeId, $type, $patchData)
        ))->toPrimitives();
    }

}