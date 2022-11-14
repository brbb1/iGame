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
        $this->container->add(Router::class);

        /** @var Router $router */
        $router = $this->container->get(Router::class);
        (require $this->getContainer()->get('config_dir') . '/routes.php')($router);
    }
}