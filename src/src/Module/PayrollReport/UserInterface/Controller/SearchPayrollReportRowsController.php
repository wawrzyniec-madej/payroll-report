<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\UserInterface\Controller;

use App\Module\PayrollReport\Application\Query\SearchPayrollReportRowsQuery;
use App\Module\PayrollReport\UserInterface\Request\GetPayrollReportRequest;
use App\Module\PayrollReport\UserInterface\View\PayrollReportRowView;
use App\Shared\UserInterface\Collection\JsonSerializableCollection;
use App\Shared\UserInterface\Exception\InvalidSortException;
use App\Shared\UserInterface\Response\BadRequestResponse;
use App\Shared\UserInterface\Response\SuccessResponse;
use App\Shared\UserInterface\View\ResultView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class SearchPayrollReportRowsController
{
    public function __construct(
        private SearchPayrollReportRowsQuery $searchPayrollReportRowsQuery
    ) {
    }

    #[Route(path: '/payroll-report/{id}/rows', methods: [Request::METHOD_GET])]
    public function __invoke(GetPayrollReportRequest $request): Response
    {
        try {
            $payrollReportRowDTOs = $this->searchPayrollReportRowsQuery->search(
                $request->getId(),
                $request->getFilters(),
                $request->getSort()
            );
        } catch (InvalidSortException $exception) {
            return new BadRequestResponse($exception->getMessage());
        }

        $payrollReportRowViews = JsonSerializableCollection::createEmpty();
        foreach ($payrollReportRowDTOs as $payrollReportRowDTO) {
            $payrollReportRowViews->add(
                new PayrollReportRowView($payrollReportRowDTO)
            );
        }

        return new SuccessResponse(
            new ResultView($payrollReportRowViews)
        );
    }
}
