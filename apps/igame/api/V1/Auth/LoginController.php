<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\API\V1\Auth;

use Brbb\Apps\IGame\API\ControllerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LoginController implements ControllerInterface
{
    public function __invoke(ServerRequestInterface $request, array $args = []): array
    {
        return ['uri' => $request->getUri(), 'method' => $request->getMethod()];
    }
}