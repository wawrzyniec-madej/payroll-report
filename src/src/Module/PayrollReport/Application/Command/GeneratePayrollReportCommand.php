<?php

namespace App\Module\PayrollReport\Application\Command;

use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Interface\GetBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\PayrollReportRepositoryInterface;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class GeneratePayrollReportCommand
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private AggregateEventDispatcherInterface $aggregateEventDispatcher,
        private GetAllEmployeesInterface $getAllEmployees,
        private GetBonusDetailsInterface $getBonusDetails,
        private PayrollReportRepositoryInterface $payrollReportRepository
    ) {
    }

    /** @throws CollectionElementInvalidException */
    public function generate(): Identifier
    {
        $employees = $this->getAllEmployees->getAll();

        $payrollReport = PayrollReport::generate(
            $this->identifierGenerator,
            $employees,
            $this->getBonusDetails
        );

        $this->payrollReportRepository->save($payrollReport);

        $this->aggregateEventDispatcher->dispatch($payrollReport);

        return $payrollReport->getId();
    }
}
