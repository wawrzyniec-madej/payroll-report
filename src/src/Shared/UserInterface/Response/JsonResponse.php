<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Response;

use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

final class JsonResponse extends BaseJsonResponse
{
    public function __construct(JsonSerializable $data, int $status = 200)
    {
        parent::__construct($data, $status);
    }
}
