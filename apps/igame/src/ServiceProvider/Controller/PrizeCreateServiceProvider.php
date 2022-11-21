<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider\Controller;

use Brbb\Apps\IGame\API\V1\Game\Prize\PrizePostController;
use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Create\CreatePrizeCommandHandler;
use Brbb\IGame\Game\Application\Prize\Create\PrizeCreator;
use League\Container\ServiceProvider\AbstractServiceProvider;

class PrizeCreateServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === PrizePostController::class;
    }

    public function register(): void
    {
        $this->container->add(CreatePrizeCommandHandler::class)
            ->addArgument(PlayerFinder::class)
            ->addArgument(PrizeCreator::class);

        $this->container->add(PrizePostController::class)
            ->addArgument(CreatePrizeCommandHandler::class);
    }
}