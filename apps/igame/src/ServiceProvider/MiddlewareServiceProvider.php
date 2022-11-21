<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\ServiceProvider;

use Brbb\Apps\IGame\Middleware\EnsureTokenMiddleware;
use Brbb\Apps\IGame\Middleware\AuthorizeValidationMiddleware;
use Brbb\Apps\IGame\Middleware\PrizePatchValidationMiddleware;
use League\Container\ServiceProvider\AbstractServiceProvider;

class MiddlewareServiceProvider extends AbstractServiceProvider
{

    public function provides(string $id): bool
    {
        return in_array($id, [
            EnsureTokenMiddleware::class,
            AuthorizeValidationMiddleware::class,
            PrizePatchValidationMiddleware::class,
        ]);
    }

    public function register(): void
    {
        $this->container->add(EnsureTokenMiddleware::class)
            ->addArgument($this->container->get('secret_key'));
        $this->container->add(AuthorizeValidationMiddleware::class);
        $this->container->add(PrizePatchValidationMiddleware::class);
    }
}