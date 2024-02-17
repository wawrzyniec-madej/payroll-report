<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;

interface PayrollReportRepositoryInterface
{
    public function save(PayrollReport $payrollReport): void;
}