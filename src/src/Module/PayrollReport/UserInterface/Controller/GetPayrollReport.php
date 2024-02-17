<?php

namespace App\Module\PayrollReport\UserInterface\Controller;

use App\Module\PayrollReport\Application\Query\GetPayrollReportQuery;
use App\Module\PayrollReport\UserInterface\View\PayrollReportView;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\UserInterface\Response\JsonResponse;
use App\Shared\UserInterface\View\ResultView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class GetPayrollReport
{
    public function __construct(
        private GetPayrollReportQuery $getPayrollReportQuery
    ) {
    }

    #[Route(path: '/payroll-report/{id}', methods: [Request::METHOD_GET])]
    public function __invoke(string $id): JsonResponse
    {
        $payrollReport = $this->getPayrollReportQuery->get(
            new Identifier($id)
        );

        return new JsonResponse(
            new ResultView(
                new PayrollReportView($payrollReport)
            )
        );
    }
}
