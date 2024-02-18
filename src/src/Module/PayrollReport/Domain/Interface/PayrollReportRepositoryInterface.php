<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;

interface PayrollReportRepositoryInterface
{
    public function save(PayrollReport $payrollReport): void;
}
