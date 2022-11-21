<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

declare(strict_types=1);

use League\Route\Router;

$projectDir = dirname(__DIR__);

// Init container
$container = require $projectDir . '/bootstrap.php';

// Process request
$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

/** @var Router $router */
$router = $container->get(Router::class);
$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);

