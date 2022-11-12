<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Factory\Router;

use Brbb\Apps\IGame\Factory\Factory;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class DefaultDispatcherFactory implements Factory
{
    public static function create(array $params): Dispatcher
    {
        return SimpleDispatcher(function (RouteCollector $r) use ($params) {
            foreach ($params as $route) {
                $r->addRoute($route['method'], $route['route'], $route['handler']);
            }
        });
    }
}