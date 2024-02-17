<?php

namespace App\Module\PayrollReport\Infrastructure\Repository;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use Doctrine\DBAL\Connection;

final class DbalPayrollReportRepository implements PayrollReportRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection
    ) {
    }

    public function save(PayrollReport $payrollReport): void
    {
        return;
    }
}