<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Http\Request;

interface RequestInterface {
    public function getMethod(): string;
    public function getUri(): string;
    public function getData(): array;
    public function addData(array $data): void;
}

