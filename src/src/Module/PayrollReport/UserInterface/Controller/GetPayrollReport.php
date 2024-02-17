<?php

namespace App\Module\PayrollReport\UserInterface\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class GetPayrollReport
{
    #[Route(path: '/payroll-report/{id}', methods: [Request::METHOD_GET])]
    public function __invoke(string $id): JsonResponse
    {
        return new JsonResponse('payroll-report '.$id);
    }
}