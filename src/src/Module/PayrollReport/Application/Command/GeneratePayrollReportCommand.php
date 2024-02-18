<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Application\Command;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Exception\InvalidDateTimeException;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GeneratePayrollReportCommand
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private AggregateEventDispatcherInterface $aggregateEventDispatcher,
        private GetAllEmployeesInterface $getAllEmployees,
        private CalculateBonusDetailsInterface $getBonusDetails,
        private GetDepartmentInterface $getDepartment
    ) {
    }

    /**
     * @throws CollectionElementInvalidException
     * @throws CannotCalculateBonusDetailsException
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     * @throws CannotGetDepartmentException
     * @throws InvalidDateTimeException
     */
    public function generate(): Identifier
    {
        $employees = $this->getAllEmployees->getAll();

        $payrollReport = PayrollReport::generate(
            $this->identifierGenerator,
            $employees,
            $this->getBonusDetails,
            $this->getDepartment
        );

        $this->aggregateEventDispatcher->dispatch($payrollReport);

        return $payrollReport->getId();
    }
}
