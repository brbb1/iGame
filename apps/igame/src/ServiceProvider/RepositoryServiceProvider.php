<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository;
use Brbb\IGame\OAuth\Infrastructure\Persistence\MySqlAuthRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Nette\Database\Connection;

class RepositoryServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {

        /** @noinspection InArrayMissUseInspection */
        return in_array($id, [
            AuthRepository::class,
        ], true);
    }

    public function register(): void
    {
        $configDir = $this->getContainer()->get('config_dir');
        $params    = (require $configDir . '/db.php')();

        $connection = new Connection($params['dns'], $params['user'], $params['password']);

        $this->container->add(AuthRepository::class,MySqlAuthRepository::class)->addArgument($connection);
    }
}