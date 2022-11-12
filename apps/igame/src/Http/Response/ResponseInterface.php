<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Http\Response;

interface ResponseInterface
{
    public function send(): void;
}