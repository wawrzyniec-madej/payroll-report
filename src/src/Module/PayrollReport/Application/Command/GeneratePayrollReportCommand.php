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
        private PayrollReportFactory $payrollReportFactory,
        private GetAllEmployeesInterface $getAllEmployees
    ) {
    }

    /**
     * @throws InvalidYearsOfSeniorityException
     * @throws InvalidDateTimeException
     * @throws CannotGetDepartmentException
     */
    public function generate(): Identifier
    {
        $employees = $this->getAllEmployees->getAll();

        $payrollReport = $this->payrollReportFactory
            ->create()
            ->generateForEmployees($employees);

        return $payrollReport->getId();
    }
}
