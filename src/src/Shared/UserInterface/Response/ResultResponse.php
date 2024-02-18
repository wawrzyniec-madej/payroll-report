<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Response;

use App\Shared\UserInterface\View\ResultView;
use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;

final class ResultResponse extends BaseJsonResponse
{
    public function __construct(JsonSerializable $data)
    {
        parent::__construct(
            new ResultView(
                $data
            )
        );
    }
}
