<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

declare(strict_types=1);

$projectDir = dirname(__DIR__);

require $projectDir . '/../bootstrap.php';

// Init DI container
$container = (new League\Container\Container())->defaultToShared();

// Add dependencies to container
$container->add('project_dir', $projectDir);
$container->add('config_dir', $projectDir . '/config');
$container->add('secret_key', $_ENV['SECRET_KEY']);

$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\RouterServiceProvider);
$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\RepositoryServiceProvider);
$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\MiddlewareServiceProvider);

// Add Application services
$container->add(\Brbb\IGame\OAuth\Application\Authenticate\UserAuthenticator::class)
    ->addArgument(\Brbb\IGame\OAuth\Domain\AuthUser\AuthRepository::class);
$container->add(\Brbb\IGame\Game\Application\Player\PlayerFinder::class)
    ->addArgument(\Brbb\IGame\Game\Domain\Player\PlayerRepository::class);

// Add controllers to container
$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\Controller\AuthorizeServiceProvider);
$container->addServiceProvider(new \Brbb\Apps\IGame\ServiceProvider\Controller\PlayerGetServiceProvider);

// Process request
$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

/** @var \League\Route\Router $router */
$router = $container->get(\League\Route\Router::class);
$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);

