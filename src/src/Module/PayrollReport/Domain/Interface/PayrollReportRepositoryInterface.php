<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Exception\PayrollReportNotFound;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\Domain\ValueObject\Identifier;

interface PayrollReportRepositoryInterface
{
    public function save(PayrollReport $payrollReport): void;

    /**
     * @throws CollectionElementInvalidException
     * @throws InvalidDateTimeException
     * @throws PayrollReportNotFound
     */
    public function getById(Identifier $id): PayrollReport;
}
