<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Event\PayrollReportGenerated;
use App\Module\PayrollReport\Domain\Interface\GetAllEmployeesInterface;
use App\Module\PayrollReport\Domain\Service\GeneratePayrollReportRowsForEmployees;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReport extends AggregateRoot
{
    public function __construct(
        private readonly GeneratePayrollReportRowsForEmployees $generatePayrollReportRowsForEmployees,
        private readonly GetAllEmployeesInterface $getAllEmployees,
        private readonly Identifier $id,
        private readonly PayrollReportRowCollection $rows,
        private readonly DateTime $generationDate
    ) {
    }

    public function generateForAllEmployees(): self
    {
        return $this->getTransaction()->start(function (): self {
            $employees = $this->getAllEmployees->getAll();

            $this->generatePayrollReportRowsForEmployees->generate($this, $employees);
            $this->addEvent(PayrollReportGenerated::create($this));
            $this->getEventDispatcher()->dispatch($this);

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
