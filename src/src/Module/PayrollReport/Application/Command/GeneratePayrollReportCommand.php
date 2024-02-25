<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Application\Command;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Factory\PayrollReportFactory;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\Interface\TransactionInterface;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GeneratePayrollReportCommand
{
    public function __construct(
        private GetAllEmployeesInterface $getAllEmployees,
        private CalculateBonusDetailsInterface $calculateBonusDetails,
        private GetDepartmentInterface $getDepartment,
        private PayrollReportFactory $payrollReportFactory,
        private IdentifierGeneratorInterface $identifierGenerator
    ) {
    }

    public function generate(): Identifier
    {
        $payrollReport = $this->payrollReportFactory
            ->create()
            ->generateForAllEmployees(
                $this->getAllEmployees,
                $this->calculateBonusDetails,
                $this->getDepartment,
                $this->identifierGenerator
            );

        return $payrollReport->getId();
    }
}
