<?php

namespace App\Module\PayrollReport\Application\Command;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\ValueObject\BonusType;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeCollection;
use App\Module\PayrollReport\Domain\ValueObject\Name;
use App\Module\PayrollReport\Domain\ValueObject\RemunerationBase;
use App\Module\PayrollReport\Domain\ValueObject\SeniorityBonus;
use App\Module\PayrollReport\Domain\ValueObject\Surname;
use App\Shared\Domain\Enum\CurrencyEnum;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;

final readonly class GeneratePayrollReportCommand
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private AggregateEventDispatcherInterface $aggregateEventDispatcher
    ) {
    }

    public function generate(): Identifier
    {
        $payrollReport = PayrollReport::generate(
            $this->identifierGenerator,
            EmployeeCollection::fromSpread(
                new Employee(
                    new Name('stiwen'),
                    new Surname('spilberg'),
                    new RemunerationBase(new Money(1000, CurrencyEnum::USD)),
                    new Department(
                        new DepartmentName('crm'),
                        new SeniorityBonus()
                    )
                )
            )
        );

        $this->aggregateEventDispatcher->dispatch($payrollReport);

        return $payrollReport->getId();
    }
}