<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;
use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Event\PayrollReportGenerated;
use App\Module\PayrollReport\Domain\Exception\CannotGetBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Interface\GetBonusDetailsInterface;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReport extends AggregateRoot
{
    private function __construct(
        private readonly Identifier $id,
        private readonly PayrollReportRowCollection $rows,
        private readonly DateTime $generationDate
    ) {
    }

    /**
     * @throws CollectionElementInvalidException
     * @throws CannotGetBonusDetailsException
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     */
    public static function generate(
        IdentifierGeneratorInterface $identifierGenerator,
        EmployeeCollection $employees,
        GetBonusDetailsInterface $getBonusDetails
    ): self {
        $payrollReport = new self(
            $identifierGenerator->generate(),
            PayrollReportRowCollection::createEmpty(),
            DateTime::now()
        );

        foreach ($employees as $employee) {
            $payrollReport->addRow(
                PayrollReportRow::generate(
                    $identifierGenerator,
                    $employee,
                    $getBonusDetails
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

    /** @throws CollectionElementInvalidException */
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
