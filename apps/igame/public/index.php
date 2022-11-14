<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

declare(strict_types=1);

$projectDir = dirname(__DIR__);

require $projectDir . '/../bootstrap.php';

// Init DI container
$container = (new League\Container\Container())->defaultToShared();

$container->add('project_dir', $projectDir);
$container->add('config_dir', $projectDir . '/config');

$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\RouterServiceProvider());
$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\DatabaseServiceProvider());

/** @var \Nette\Database\Connection $database */
$database = $container->get(\Nette\Database\Connection::class);

// Process request
/** @var \League\Route\Router $router */
$router = $container->get(\League\Route\Router::class);

