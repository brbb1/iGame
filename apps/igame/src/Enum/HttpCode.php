<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Enum;

enum HttpCode: int
{
    case OK = 200;
    case NOT_AUTHORIZED = 501;
    case NOT_FOUND = 404;
    case NOT_ALLOWED = 405;
}