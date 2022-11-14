<?php

declare(strict_types=1);

use Brbb\Apps\IGame\API\V1\Auth\LoginController;
use Brbb\Apps\IGame\API\V1\Game\Players\PlayerGetController;
use Brbb\Apps\IGame\Http\HttpMethod;
use Laminas\Diactoros\ResponseFactory;
use League\Route\RouteGroup;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;

return static function (Router $router) {
    //set response type to json
    $responseFactory = new ResponseFactory();
    $strategy = new JsonStrategy($responseFactory);
    $router->setStrategy($strategy);

    //set routes
    $router->group('/v1', function (RouteGroup $router) {
        $router->map(HttpMethod::GET->value, '/auth/login', LoginController::class);
        $router->map(HttpMethod::GET->value, '/game/players/{id:number}', PlayerGetController::class);
    });
};