<?php

declare(strict_types=1);

use Brbb\Apps\IGame\API\V1\Game\Players\PlayerGetController;
use Brbb\Apps\IGame\API\V1\Auth\LoginController;
use Brbb\Apps\IGame\Http\HttpMethod;

return static function (): array {
    return [
        ['route' => '/v1/auth/login', 'method' => HttpMethod::GET, 'handler' => LoginController::class,],
        ['route' => '/v1/game/players/{id:\\d+}', 'method' => HttpMethod::GET, 'handler' => PlayerGetController::class,],
    ];
};
