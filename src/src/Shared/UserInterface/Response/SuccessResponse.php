<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Response;

use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

final class SuccessResponse extends BaseJsonResponse
{
    public function __construct(JsonSerializable $data)
    {
        parent::__construct($data);
    }
}
