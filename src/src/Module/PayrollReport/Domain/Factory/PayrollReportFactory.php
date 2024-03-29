<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Factory;

use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Service\GeneratePayrollReportRowsForEmployees;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\Interface\TransactionInterface;

final readonly class PayrollReportFactory
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private TransactionInterface $transaction,
        private AggregateEventDispatcherInterface $aggregateEventDispatcher,
        private GeneratePayrollReportRowsForEmployees $generatePayrollReportRowsForEmployees,
        private GetAllEmployeesInterface $getAllEmployees
    ) {
    }

    public function create(): PayrollReport
    {
        $instance = new PayrollReport(
            $this->getAllEmployees,
            $this->generatePayrollReportRowsForEmployees,
            $this->identifierGenerator->generate(),
            PayrollReportRowCollection::createEmpty(),
            DateTime::now()
        );

        $instance
            ->setTransaction($this->transaction)
            ->setEventDispatcher($this->aggregateEventDispatcher);

        return $instance;
    }
}
