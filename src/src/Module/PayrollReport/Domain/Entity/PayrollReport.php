<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Event\PayrollReportGenerated;
use App\Module\PayrollReport\Domain\Service\GeneratePayrollReportRowsForAllEmployees;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\TransactionInterface;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReport extends AggregateRoot
{
    /** @param TransactionInterface<self> $transaction */
    public function __construct(
        private readonly GeneratePayrollReportRowsForAllEmployees $generatePayrollReportRowsForAllEmployees,
        private readonly AggregateEventDispatcherInterface $aggregateEventDispatcher,
        private readonly TransactionInterface $transaction,
        private readonly Identifier $id,
        private readonly PayrollReportRowCollection $rows,
        private readonly DateTime $generationDate
    ) {
    }

    public function generateForAllEmployees(): self
    {
        return $this->transaction->start(function (): self {
            $this->generatePayrollReportRowsForAllEmployees->generate($this);
            $this->addEvent(PayrollReportGenerated::create($this));
            $this->aggregateEventDispatcher->dispatch($this);

            return $this;
        });
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getRows(): PayrollReportRowCollection
    {
        return $this->rows;
    }

    public function addRow(PayrollReportRow $row): self
    {
        $this->rows->add($row);

        return $this;
    }

    public function getGenerationDate(): DateTime
    {
        return $this->generationDate;
    }
}
