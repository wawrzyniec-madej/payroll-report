<?php

namespace App\Shared\UserInterface\Response;

use Symfony\Component\HttpFoundation\Response as BaseResponse;

final class NotFoundResponse extends BaseResponse
{
    public function __construct()
    {
        parent::__construct(null, 404);
    }
}