<?php

declare(strict_types=1);

use Brbb\Apps\IGame\API\V1\Game\Draws\DrawsGetController;
use Brbb\Apps\IGame\API\V1\Game\Prize\PrizeGetController;
use Brbb\Apps\IGame\API\V1\Game\Prize\PrizePatchController;
use Brbb\Apps\IGame\API\V1\Game\Prize\PrizePostController;
use Brbb\Apps\IGame\API\V1\OAuth\AuthorizeController;
use Brbb\Apps\IGame\API\V1\Game\Players\PlayerGetController;
use Brbb\Apps\IGame\Enum\HttpMethod;
use Brbb\Apps\IGame\Middleware\AuthorizeValidationMiddleware;
use Brbb\Apps\IGame\Middleware\EnsureTokenMiddleware;
use Brbb\Apps\IGame\Middleware\PrizePatchValidationMiddleware;
use League\Route\RouteGroup;
use League\Route\Router;

return static function (Router $router): void {
    //set routes
    $router->group('/v1', function (RouteGroup $router) {
        $router->map(HttpMethod::POST->value, '/oauth/authorize', AuthorizeController::class)
            ->lazyMiddlewares([AuthorizeValidationMiddleware::class]);

        $router->map(HttpMethod::GET->value, '/game/players', PlayerGetController::class)
            ->lazyMiddlewares([EnsureTokenMiddleware::class]);

        $router->map(HttpMethod::GET->value, '/game/draws', DrawsGetController::class)
            ->lazyMiddlewares([EnsureTokenMiddleware::class]);

        $router->map(HttpMethod::GET->value, '/game/draws/{drawId:number}/prizes', PrizeGetController::class)
            ->lazyMiddlewares([EnsureTokenMiddleware::class]);

        $router->map(HttpMethod::POST->value, '/game/draws/{drawId:number}/prizes', PrizePostController::class)
            ->lazyMiddlewares([EnsureTokenMiddleware::class]);

        $router->map(HttpMethod::PATCH->value, '/game/prizes/{prizeType:word}/{id:number}', PrizePatchController::class)
            ->lazyMiddlewares([EnsureTokenMiddleware::class, PrizePatchValidationMiddleware::class,]);
    });
};