<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider\Controller;

use Brbb\Apps\IGame\API\V1\Game\Prize\PrizeGetController;
use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Find\FindPrizesQueryHandler;
use Brbb\IGame\Game\Application\Prize\Find\PrizeFinder;
use League\Container\ServiceProvider\AbstractServiceProvider;

class PrizeGetServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === PrizeGetController::class;
    }

    public function register(): void
    {
        $this->container->add(FindPrizesQueryHandler::class)
            ->addArgument(PlayerFinder::class)
            ->addArgument(PrizeFinder::class);

        $this->container->add(PrizeGetController::class)
            ->addArgument(FindPrizesQueryHandler::class);
    }
}