<?php

declare(strict_types=1);

use Brbb\Apps\IGame\Http\Request\JsonRequest;
use Brbb\Apps\IGame\Kernel;

require dirname(__DIR__) . '/../bootstrap.php';

$kernel = new Kernel();
$request = new JsonRequest();
$response = $kernel->dispatch($request);
$response->send();
