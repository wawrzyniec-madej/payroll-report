<?php

namespace App\Module\PayrollReport\UserInterface\Controller;

use App\Module\PayrollReport\Application\Query\GetPayrollReportQuery;
use App\Module\PayrollReport\Domain\Exception\PayrollReportNotFound;
use App\Module\PayrollReport\UserInterface\Request\GetPayrollReportRequest;
use App\Module\PayrollReport\UserInterface\View\PayrollReportView;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\UserInterface\Response\JsonResponse;
use App\Shared\UserInterface\Response\NotFoundResponse;
use App\Shared\UserInterface\View\ResultView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class GetPayrollReportController
{
    public function __construct(
        private GetPayrollReportQuery $getPayrollReportQuery
    ) {
    }

    /**
     * @throws CollectionElementInvalidException
     * @throws InvalidDateTimeException
     */
    #[Route(path: '/payroll-report/{id}', methods: [Request::METHOD_GET])]
    public function __invoke(GetPayrollReportRequest $request): Response
    {
        try {
            $payrollReport = $this->getPayrollReportQuery->get(
                $request->getId(),
                $request->getFilters(),
                $request->getSort()
            );
        } catch (PayrollReportNotFound) {
            return new NotFoundResponse();
        }

        return new JsonResponse(
            new ResultView(
                new PayrollReportView($payrollReport)
            )
        );
    }
}
