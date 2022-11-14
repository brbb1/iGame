<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Nette\Database\Connection;

class DatabaseServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return $id === Connection::class;
    }

    public function register(): void
    {
        $configDir = $this->getContainer()->get('config_dir');
        $params    = (require $configDir . '/db.php')();

        $this->container->add(Connection::class)
            ->addArgument($params['dns'])
            ->addArgument($params['user'])
            ->addArgument($params['password']
            );
    }
}