<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Http\Request;

use Brbb\Apps\IGame\Http\HttpMethod;

class JsonRequest implements RequestInterface {
    private string $method;
    private string $uri;
    private array $data;

    /** @throws \JsonException */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $this->uri = rawurldecode($uri);

        $queryData = [];
        parse_str($_SERVER['QUERY_STRING'], $queryData);

        $postData = [];
        if ($this->method !== HttpMethod::GET->name) {
            $postData = json_decode(
                file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR
            );
        }

        $this->data = array_merge($queryData, $postData);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function addData(array $data): void
    {
        $this->data = array_merge($this->data, $data);
    }
}

