<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Http;

enum HttpMethod
{
    case GET;
    case POST;
    case PATCH;
    case PUT;
    case DELETE;
}