<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider\Controller;

use Brbb\Apps\IGame\API\V1\Game\Players\PlayerGetController;
use Brbb\IGame\Game\Application\Player\Find\FindPlayerQueryHandler;
use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use League\Container\ServiceProvider\AbstractServiceProvider;

class PlayerGetServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === PlayerGetController::class;
    }

    public function register(): void
    {
        $this->container->add(FindPlayerQueryHandler::class)
            ->addArgument(PlayerFinder::class);

        $this->container->add(PlayerGetController::class)
            ->addArgument(FindPlayerQueryHandler::class);
    }
}