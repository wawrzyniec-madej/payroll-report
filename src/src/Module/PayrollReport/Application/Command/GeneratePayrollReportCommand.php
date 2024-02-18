<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Application\Command;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Shared\Application\Interface\TransactionInterface;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GeneratePayrollReportCommand
{
    /** @param TransactionInterface<Identifier> $transaction */
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private AggregateEventDispatcherInterface $aggregateEventDispatcher,
        private GetAllEmployeesInterface $getAllEmployees,
        private CalculateBonusDetailsInterface $getBonusDetails,
        private GetDepartmentInterface $getDepartment,
        private TransactionInterface $transaction
    ) {
    }

    public function generate(): Identifier
    {
        /* This doesn't work with my phpstan setup, as stan does not report exceptions from callables, even if they are executed at once */
        return $this->transaction->start(function (): Identifier {
            $employees = $this->getAllEmployees->getAll();

            $payrollReport = PayrollReport::generate(
                $this->identifierGenerator,
                $employees,
                $this->getBonusDetails,
                $this->getDepartment
            );

            $this->aggregateEventDispatcher->dispatch($payrollReport);

            return $payrollReport->getId();
        });
    }
}
