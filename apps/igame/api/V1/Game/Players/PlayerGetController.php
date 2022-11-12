<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Game\Players;

use Brbb\Apps\IGame\API\ControllerInterface;
use Brbb\Apps\IGame\Http\Request\RequestInterface;
use Brbb\Apps\IGame\Http\Response\JsonResponse;
use Brbb\Apps\IGame\Http\Response\ResponseInterface;

final class PlayerGetController implements ControllerInterface
{
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['uri' => $request->getUri(), 'method' => $request->getMethod(), 'data' => $request->getData()]);
    }
}