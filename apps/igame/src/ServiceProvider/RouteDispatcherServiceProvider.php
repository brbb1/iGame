<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use League\Container\ServiceProvider\AbstractServiceProvider;
use function FastRoute\simpleDispatcher;

class RouteDispatcherServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === Dispatcher::class;
    }

    public function register(): void
    {
        $configDir = $this->getContainer()->get('config_dir');

        $this->getContainer()->add(Dispatcher::class, function () use ($configDir) {
            return SimpleDispatcher(function (RouteCollector $r) use ($configDir) {
                $params = (require $configDir . '/routes.php')();
                foreach ($params as $route) {
                    $r->addRoute($route['method'], $route['route'], $route['handler']);
                }
            });
        });
    }
}