<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Exception\PayrollReportNotFound;
use App\Shared\Domain\ValueObject\Identifier;

interface PayrollReportRepositoryInterface
{
    public function save(PayrollReport $payrollReport): void;

    /** @throws PayrollReportNotFound */
    public function getById(Identifier $id): PayrollReport;
}