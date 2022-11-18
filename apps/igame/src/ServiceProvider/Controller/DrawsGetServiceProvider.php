<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider\Controller;

use Brbb\Apps\IGame\API\V1\Game\Draws\DrawsGetController;
use Brbb\IGame\Game\Application\Draw\DrawFinder;
use Brbb\IGame\Game\Application\Draw\FindDrawsQueryHandler;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DrawsGetServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === DrawsGetController::class;
    }

    public function register(): void
    {
        $this->container->add(FindDrawsQueryHandler::class)
            ->addArgument(DrawFinder::class);

        $this->container->add(DrawsGetController::class)
            ->addArgument(FindDrawsQueryHandler::class);
    }
}