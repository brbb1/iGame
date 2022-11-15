<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Router\Strategy;

use League\Container\DefinitionContainerInterface;
use League\Route\Strategy\ApplicationStrategy;
use League\Route\Strategy\JsonStrategy;

class JsonWithContainerStrategy extends JsonStrategy
{
    private ApplicationStrategy $applicationStrategy;

    public function __construct(DefinitionContainerInterface $container)
    {
        $this->applicationStrategy = new ApplicationStrategy();
        $this->applicationStrategy->setContainer($container);
    }


}