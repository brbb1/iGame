<?php

namespace Brbb\Apps\IGame\API;

use Brbb\Apps\IGame\Http\Request\RequestInterface;
use Brbb\Apps\IGame\Http\Response\ResponseInterface;

interface ControllerInterface
{
    public function __invoke(RequestInterface $request): ResponseInterface;
}