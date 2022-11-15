<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Players;

use Brbb\Apps\IGame\API\ControllerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PlayerGetController implements ControllerInterface
{
    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        return [
            'uri' => $request->getUri()->getPath(),
            'method' => $request->getMethod(),
            'data' => $request->getUri()->getQuery(),
            'args' => $args,
            'post' => $request->getParsedBody()
        ];
    }
}