<?php

namespace App\Module\PayrollReport\Application\Query;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Shared\Domain\ValueObject\Identifier;

final class GetPayrollReportQuery
{
    public function __construct(
        private readonly PayrollReportRepositoryInterface $payrollReportRepository
    ) {
    }

    public function get(Identifier $id): PayrollReport
    {
        return $this->payrollReportRepository->getById($id);
    }
}