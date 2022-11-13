<?php /** @noinspection PhpPossiblePolymorphicInvocationInspection */

declare(strict_types=1);

use Brbb\Apps\IGame\Http\HttpCode;
use Brbb\Apps\IGame\Http\Request\JsonRequest;
use Brbb\Apps\IGame\Http\Response\JsonErrorResponse;
use Brbb\Apps\IGame\ServiceProvider\RouteDispatcherServiceProvider;
use FastRoute\Dispatcher;
use League\Container\Container;

$projectDir = dirname(__DIR__);

require $projectDir . '/../bootstrap.php';

$container = (new Container())->defaultToShared();

$container->add('project_dir', $projectDir);
$container->add('config_dir', $projectDir . '/config');
$container->addServiceProvider(new RouteDispatcherServiceProvider());

$request = new JsonRequest();

/** @var Dispatcher $routeDispatcher */
$routeDispatcher = $container->get(Dispatcher::class);
$routeInfo = $routeDispatcher->dispatch($request->getMethod(), $request->getUri());

$response =  match ($routeInfo[0]) {
    Dispatcher::FOUND => (new $routeInfo[1]())($request->addData($routeInfo[2])),
    Dispatcher::NOT_FOUND => new JsonErrorResponse(HttpCode::NOT_FOUND->value, 'Resource not found'),
    Dispatcher::METHOD_NOT_ALLOWED => new JsonErrorResponse(HttpCode::NOT_ALLOWED->value, 'Method not allowed'),
};

$response->send();
