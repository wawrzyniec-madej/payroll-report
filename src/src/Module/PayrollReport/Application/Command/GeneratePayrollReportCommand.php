<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Application\Command;

use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Factory\PayrollReportFactory;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\Domain\ValueObject\Identifier;

/**
 *
 */
final readonly class GeneratePayrollReportCommand
{
    public function __construct(
        private PayrollReportFactory $payrollReportFactory
    ) {
    }

    public function generate(): Identifier
    {
        $payrollReport = $this->payrollReportFactory
            ->create()
            ->generateForAllEmployees();

        return $payrollReport->getId();
    }
}
