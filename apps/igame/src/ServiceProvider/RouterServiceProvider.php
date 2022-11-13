<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;

class RouterServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === Router::class;
    }

    public function register(): void
    {
        $configDir = $this->getContainer()->get('config_dir');

        $this->container->add(Router::class);

        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $params = (require $configDir . '/routes.php')();
        foreach ($params as $param) {
            $router->map($param['method'], $param['route'], $param['handler']);
        }
    }
}