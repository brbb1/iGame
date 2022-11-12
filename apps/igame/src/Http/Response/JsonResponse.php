<?php

declare(strict_types=1);

namespace Brbb\Apps\IGame\Http\Response;

use Brbb\Apps\IGame\Http\HttpCode;

class JsonResponse implements ResponseInterface
{
    public function __construct(private readonly array $data)
    {
    }

    /** @throws \JsonException */
    public function send(): void
    {
        http_response_code(HttpCode::OK->value);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(['data' => $this->data], JSON_THROW_ON_ERROR);
    }
}