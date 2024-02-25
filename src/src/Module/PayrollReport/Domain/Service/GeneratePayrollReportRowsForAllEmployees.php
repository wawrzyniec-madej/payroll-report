<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Service;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Entity\PayrollReportRow;
use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;

final readonly class GeneratePayrollReportRowsForAllEmployees
{
    public function __construct(
        private GetAllEmployeesInterface $getAllEmployees,
        private CalculateBonusDetailsInterface $calculateBonusDetails,
        private GetDepartmentInterface $getDepartment,
        private IdentifierGeneratorInterface $identifierGenerator
    ) {
    }

    /**
     * @throws CannotGetDepartmentException
     * @throws InvalidYearsOfSeniorityException
     * @throws InvalidDateTimeException
     * @throws CannotCalculateBonusDetailsException
     * @throws CannotGetDepartmentException
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     */
    public function generate(PayrollReport $payrollReport): PayrollReport
    {
        foreach ($this->getAllEmployees->getAll() as $employee) {
            $payrollReport->addRow(
                PayrollReportRow::generate(
                    $this->identifierGenerator->generate(),
                    $employee,
                    $this->calculateBonusDetails,
                    $this->getDepartment
                )
            );
        }

        return $payrollReport;
    }
}
