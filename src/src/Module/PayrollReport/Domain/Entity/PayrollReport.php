<?php

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Event\PayrollReportGenerated;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeCollection;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReport extends AggregateRoot
{
    private function __construct(
        private Identifier $id
    ) {
    }

    public static function generate(
        IdentifierGeneratorInterface $identifierGenerator,
        EmployeeCollection $employees,
    ): self {
        $payrollReport = new self(
            $identifierGenerator->generate()
        );

        foreach ($employees as $employee) {
            $payrollReport->addRow(
                PayrollReportRow::createForEmployee(
                    $identifierGenerator,
                    $payrollReport,
                    $employee
                )
            );
        }


        $payrollReport->addEvent(
            PayrollReportGenerated::create(
                $payrollReport
            )
        );

        return $payrollReport;
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
}