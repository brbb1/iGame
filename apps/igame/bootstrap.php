<?php

declare(strict_types=1);

use Brbb\Apps\IGame\ServiceProvider\Controller\AuthorizeServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\Controller\DrawsGetServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\Controller\PlayerGetServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\Controller\PrizeCreateServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\Controller\PrizeGetServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\Controller\PrizePatchServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\MiddlewareServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\RepositoryServiceProvider;
use Brbb\Apps\IGame\ServiceProvider\RouterServiceProvider;
use Brbb\IGame\Game\Application\Draw\Find\DrawFinder;
use Brbb\IGame\Game\Application\Player\Find\PlayerFinder;
use Brbb\IGame\Game\Application\Prize\Create\PrizeCreator;
use Brbb\IGame\Game\Application\Prize\Find\PrizeFinder;
use Brbb\IGame\Game\Application\Prize\Update\PrizeStatusChanger;
use Brbb\IGame\Game\Application\Terms\Find\TermsFinder;
use Brbb\IGame\Game\Domain\Draw\DrawRepository;
use Brbb\IGame\Game\Domain\MaterialObject\MaterialObjectRepository;
use Brbb\IGame\Game\Domain\Money\MoneyRepository;
use Brbb\IGame\Game\Domain\Player\PlayerRepository;
use Brbb\IGame\Game\Domain\Points\PointsRepository;
use Brbb\IGame\Game\Domain\Terms\TermsRepository;
use Brbb\IGame\OAuth\Application\Authenticate\UserAuthenticator;
use Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository;
use Contributte\Database\Transaction\Transaction;

$projectDir = dirname(__DIR__);

require $projectDir . '/bootstrap.php';

// Init DI container
$container = (new League\Container\Container())->defaultToShared();

// Add dependencies to container
$container->add('project_dir', $projectDir . '/igame');
$container->add('config_dir', $projectDir . '/igame/config');
$container->add('secret_key', $_ENV['SECRET_KEY']);

$container->addServiceProvider(new RouterServiceProvider);
$container->addServiceProvider(new RepositoryServiceProvider);
$container->addServiceProvider(new MiddlewareServiceProvider);

// Add Application services
$container->add(UserAuthenticator::class)
    ->addArgument(AuthRepository::class);
$container->add(PlayerFinder::class)
    ->addArgument(PlayerRepository::class);
$container->add(PrizeFinder::class)
    ->addArgument(PointsRepository::class)
    ->addArgument(MoneyRepository::class)
    ->addArgument(MaterialObjectRepository::class);
$container->add(DrawFinder::class)
    ->addArgument(DrawRepository::class);
$container->add(TermsFinder::class)
    ->addArgument(TermsRepository::class);
$container->add(PrizeStatusChanger::class)
    ->addArgument(Transaction::class)
    ->addArgument(PointsRepository::class)
    ->addArgument(MoneyRepository::class)
    ->addArgument(MaterialObjectRepository::class)
    ->addArgument(PrizeCreator::class);
$container->add(PrizeCreator::class)
    ->addArgument(Transaction::class)
    ->addArgument(PlayerFinder::class)
    ->addArgument(TermsFinder::class)
    ->addArgument(PointsRepository::class)
    ->addArgument(MoneyRepository::class)
    ->addArgument(MaterialObjectRepository::class);

// Add controllers to container
$container->addServiceProvider(new AuthorizeServiceProvider);
$container->addServiceProvider(new DrawsGetServiceProvider);
$container->addServiceProvider(new PlayerGetServiceProvider);
$container->addServiceProvider(new PrizeCreateServiceProvider);
$container->addServiceProvider(new PrizeGetServiceProvider());
$container->addServiceProvider(new PrizePatchServiceProvider());

return $container;
