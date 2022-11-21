<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider\Controller;

use Brbb\Apps\IGame\API\V1\Game\Prize\PrizePatchController;
use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Find\PrizeFinder;
use Brbb\IGame\Game\Application\Prize\Update\PrizeStatusChanger;
use Brbb\IGame\Game\Application\Prize\Update\UpdatePrizeCommandHandler;
use League\Container\ServiceProvider\AbstractServiceProvider;

class PrizePatchServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === PrizePatchController::class;
    }

    public function register(): void
    {
        $this->container->add(UpdatePrizeCommandHandler::class)
            ->addArgument(PlayerFinder::class)
            ->addArgument(PrizeFinder::class)
            ->addArgument(PrizeStatusChanger::class);

        $this->container->add(PrizePatchController::class)
            ->addArgument(UpdatePrizeCommandHandler::class);
    }
}