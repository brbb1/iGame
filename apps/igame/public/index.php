<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

declare(strict_types=1);

use League\Container\Container;

$projectDir = dirname(__DIR__);

require $projectDir . '/../bootstrap.php';

// Init DI container
$container = (new Container())->defaultToShared();

$container->add('project_dir', $projectDir);
$container->add('config_dir', $projectDir . '/config');

$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\RouterServiceProvider());

// Process request
/** @var \League\Route\Router $router */
$router = $container->get(\League\Route\Router::class);

