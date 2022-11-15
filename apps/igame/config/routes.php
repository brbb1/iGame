<?php

declare(strict_types=1);

use Brbb\Apps\IGame\API\V1\OAuth\AuthorizeController;
use Brbb\Apps\IGame\API\V1\Game\Players\PlayerGetController;
use Brbb\Apps\IGame\Http\HttpMethod;
use League\Route\RouteGroup;
use League\Route\Router;

return static function (Router $router): void {
    //set routes
    $router->group('/v1', function (RouteGroup $router) {
        $router->map(HttpMethod::PUT->value, '/oauth/authorize', AuthorizeController::class);
        $router->map(HttpMethod::GET->value, '/game/players/{id:number}', PlayerGetController::class);
    });
};