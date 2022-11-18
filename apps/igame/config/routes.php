<?php

declare(strict_types=1);

use Brbb\Apps\IGame\API\V1\OAuth\AuthorizeController;
use Brbb\Apps\IGame\API\V1\Game\Players\PlayerGetController;
use Brbb\Apps\IGame\Enum\HttpMethod;
use League\Route\RouteGroup;
use League\Route\Router;

return static function (Router $router): void {
    //set routes
    $router->group('/v1', function (RouteGroup $router) {
        $router->map(HttpMethod::POST->value, '/oauth/authorize', AuthorizeController::class)
            ->lazyMiddlewares([\Brbb\Apps\IGame\Middleware\AuthorizeValidationMiddleware::class]);

        $router->map(HttpMethod::GET->value, '/game/players/{id:number}', PlayerGetController::class)
            ->lazyMiddlewares([\Brbb\Apps\IGame\Middleware\EnsureTokenMiddleware::class]);
    });
};