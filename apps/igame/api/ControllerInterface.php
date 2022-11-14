<?php

namespace Brbb\Apps\IGame\API;

use Psr\Http\Message\ServerRequestInterface;

interface ControllerInterface
{
    public function __invoke(ServerRequestInterface $request, array $args = []): array;
}