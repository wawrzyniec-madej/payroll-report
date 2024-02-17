<?php

namespace App\Module\PayrollReport\Application\Query;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Exception\PayrollReportNotFound;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Shared\Application\FilterAndSort\Collection\FilterCollection;
use App\Shared\Application\FilterAndSort\Collection\SortCollection;
use App\Shared\Application\FilterAndSort\Sort;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetPayrollReportQuery
{
    public function __construct(
        private PayrollReportRepositoryInterface $payrollReportRepository
    ) {
    }

    /**
     * @throws PayrollReportNotFound
     * @throws CollectionElementInvalidException
     * @throws InvalidDateTimeException
     */
    public function get(
        Identifier $id,
        FilterCollection $filters,
        ?Sort $sort
    ): PayrollReport {
        return $this->payrollReportRepository->getById($id, $filters, $sort);
    }
}
