<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Response;

use App\Shared\UserInterface\View\BadRequestView;
use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

final class BadRequestResponse extends BaseJsonResponse
{
    public function __construct(string $message)
    {
        parent::__construct(
            new BadRequestView($message),
            400
        );
    }
}
