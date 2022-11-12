<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Factory;

interface Factory
{
    public static function create(array $params): mixed;
}