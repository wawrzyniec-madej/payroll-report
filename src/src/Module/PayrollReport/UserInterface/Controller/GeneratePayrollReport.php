<?php

namespace App\Module\PayrollReport\UserInterface\Controller;

use App\Module\PayrollReport\Application\Command\GeneratePayrollReportCommand;
use App\Shared\UserInterface\Response\JsonResponse;
use App\Shared\UserInterface\View\IdentifierView;
use App\Shared\UserInterface\View\ResultView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final class GeneratePayrollReport
{
    public function __construct(
        private readonly GeneratePayrollReportCommand $generatePayrollReportCommand
    ) {
    }

    #[Route(path: '/payroll-report/generate', methods: [Request::METHOD_POST])]
    public function __invoke(): JsonResponse
    {
        $payrollReportIdentifier = $this->generatePayrollReportCommand->generate();

        return new JsonResponse(
            new ResultView(
                new IdentifierView($payrollReportIdentifier)
            )
        );
    }
}
