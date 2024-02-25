<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;
use App\Module\PayrollReport\Domain\Collection\PayrollReportRowCollection;
use App\Module\PayrollReport\Domain\Event\PayrollReportGenerated;
use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\DateTime;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Interface\AggregateEventDispatcherInterface;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\Interface\TransactionInterface;
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
     * @param TransactionInterface<PayrollReport> $transaction
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     * @throws CannotGetDepartmentException
     * @throws CannotCalculateBonusDetailsException
     */
    public static function generate(
        AggregateEventDispatcherInterface $aggregateEventDispatcher,
        TransactionInterface $transaction,
        IdentifierGeneratorInterface $identifierGenerator,
        EmployeeCollection $employees,
        CalculateBonusDetailsInterface $getBonusDetails,
        GetDepartmentInterface $getDepartment
    ): self {
        /**
         * @throws InvalidYearsOfSeniorityException
         * @throws IncompatibleMoneyException
         * @throws CannotGetDepartmentException
         * @throws CannotCalculateBonusDetailsException
         */
        return $transaction->start(
            function () use (
                $getDepartment,
                $getBonusDetails,
                $employees,
                $identifierGenerator,
                $aggregateEventDispatcher
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
                            $getBonusDetails,
                            $getDepartment
                        )
                    );
                }

                $payrollReport->addEvent(
                    PayrollReportGenerated::create(
                        $payrollReport
                    )
                );

                $aggregateEventDispatcher->dispatch($payrollReport);

                return $payrollReport;
            }
        );
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
