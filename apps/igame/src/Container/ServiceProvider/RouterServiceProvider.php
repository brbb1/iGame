<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Container\ServiceProvider;

use Laminas\Diactoros\ResponseFactory;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Router;
use League\Route\Strategy\JsonStrategy;

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

        //set response type to json
        $responseFactory = new ResponseFactory();
        $strategy = new JsonStrategy($responseFactory);
        $strategy->setContainer($this->container);
        $router->setStrategy($strategy);

        (require $this->getContainer()->get('config_dir') . '/routes.php')($router);
    }
}