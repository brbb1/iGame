<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider\Controller;

use Brbb\Apps\IGame\API\V1\OAuth\AuthorizeController;
use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\OAuth\Application\Authenticate\AuthenticateUserCommandHandler;
use Brbb\IGame\OAuth\Application\Authenticate\UserAuthenticator;
use League\Container\ServiceProvider\AbstractServiceProvider;

class AuthorizeServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === AuthorizeController::class;
    }

    public function register(): void
    {
        $this->container->add(AuthenticateUserCommandHandler::class)
            ->addArgument(UserAuthenticator::class);

        $this->container->add(AuthorizeController::class)
            ->addArgument(AuthenticateUserCommandHandler::class)
            ->addArgument($this->container->get('secret_key'));
    }
}