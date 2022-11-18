<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use Brbb\IGame\Game\Domain\Draw\DrawRepository;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlDrawRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlPlayerRepository;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository;
use Brbb\IGame\OAuth\Infrastructure\Persistence\MySqlAuthRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Nette\Database\Connection;

class RepositoryServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {

        return in_array($id, [
            AuthRepository::class,
            PlayerRepository::class,
            DrawRepository::class,
        ], true);
    }

    public function register(): void
    {
        $configDir = $this->getContainer()->get('config_dir');
        $params    = (require $configDir . '/db.php')();

        $connection = new Connection($params['dns'], $params['user'], $params['password']);

        $this->container->add(AuthRepository::class,MySqlAuthRepository::class)->addArgument($connection);
        $this->container->add(PlayerRepository::class,MySqlPlayerRepository::class)->addArgument($connection);
        $this->container->add(DrawRepository::class,MySqlDrawRepository::class)->addArgument($connection);
    }
}