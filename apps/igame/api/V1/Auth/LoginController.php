<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Auth;

use Brbb\Apps\IGame\Http\Request\RequestInterface;
use Brbb\Apps\IGame\Http\Response\JsonResponse;
use Brbb\Apps\IGame\Http\Response\ResponseInterface;

final class LoginController
{
    public function __invoke(RequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['uri' => $request->getUri(), 'method' => $request->getMethod()]);
    }
}