<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Http\Response;

class JsonErrorResponse implements ResponseInterface
{
    public function __construct(
        private readonly int    $code,
        private readonly string $message
    )
    {
    }

    /** @throws \JsonException */
    public function send(): void
    {
        http_response_code($this->code);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(['error' => ['code' => $this->code, 'message' => $this->message]], JSON_THROW_ON_ERROR);
    }
}