<?php

namespace App\Module\PayrollReport\Application\Query;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Exception\PayrollReportNotFound;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GetPayrollReportQuery
{
    public function __construct(
        private PayrollReportRepositoryInterface $payrollReportRepository
    ) {
    }

    /** @throws PayrollReportNotFound */
    public function get(Identifier $id): PayrollReport
    {
        return $this->payrollReportRepository->getById($id);
    }
}
