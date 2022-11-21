<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use Brbb\IGame\Game\Domain\Draw\DrawRepository;
use Brbb\IGame\Game\Domain\MaterialObject\MaterialObjectRepository;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Game\Domain\Points\PointsRepository;
use Brbb\IGame\Game\Domain\Prize\PrizeRepository;
use Brbb\IGame\Game\Domain\Terms\TermsRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlDrawRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlMaterialObjectRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlMoneyRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlPlayerRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlPointsRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlPrizeRepository;
use Brbb\IGame\Game\Infrastructure\Persistence\MySqlTermsRepository;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository;
use Brbb\IGame\OAuth\Infrastructure\Persistence\MySqlAuthRepository;
use Contributte\Database\Transaction\Transaction;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Nette\Database\Connection;

class RepositoryServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {

        return in_array($id, [
            Transaction::class,
            AuthRepository::class,
            PlayerRepository::class,
            DrawRepository::class,
            PointsRepository::class,
            MoneyRepository::class,
            MaterialObjectRepository::class,
            TermsRepository::class,
        ], true);
    }

    public function register(): void
    {
        $configDir = $this->getContainer()->get('config_dir');
        $params    = (require $configDir . '/db.php')();

        $connection = new Connection($params['dns'], $params['user'], $params['password']);

        $this->container->add(Transaction::class)->addArgument($connection);
        $this->container->add(AuthRepository::class,MySqlAuthRepository::class)->addArgument($connection);
        $this->container->add(PlayerRepository::class,MySqlPlayerRepository::class)->addArgument($connection);
        $this->container->add(DrawRepository::class,MySqlDrawRepository::class)->addArgument($connection);
        $this->container->add(TermsRepository::class,MySqlTermsRepository::class)->addArgument($connection);
        $this->container->add(PointsRepository::class,MySqlPointsRepository::class)->addArgument($connection);
        $this->container->add(MoneyRepository::class,MySqlMoneyRepository::class)->addArgument($connection);
        $this->container->add(MaterialObjectRepository::class,MySqlMaterialObjectRepository::class)->addArgument($connection);
    }
}