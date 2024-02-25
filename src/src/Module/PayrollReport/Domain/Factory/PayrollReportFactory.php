<?php

namespace App\Module\PayrollReport\Domain\Factory;

use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Entity\PayrollReport;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\Interface\TransactionInterface;

final readonly class PayrollReportFactory
{
    public function __construct(
        private IdentifierGeneratorInterface $identifierGenerator,
        private TransactionInterface $transaction,
        private AggregateEventDispatcherInterface $aggregateEventDispatcher
    ) {
    }

    public function create(): PayrollReport
    {
        return new PayrollReport(
            $this->aggregateEventDispatcher,
            $this->transaction,
            $this->identifierGenerator->generate(),
            PayrollReportRowCollection::createEmpty(),
            DateTime::now()
        );
    }
}