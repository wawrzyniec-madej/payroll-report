<?php

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Interface\BonusInterface;
use App\Module\PayrollReport\Domain\ValueObject\AdditionToBase;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\Name;
use App\Module\PayrollReport\Domain\ValueObject\RemunerationBase;
use App\Module\PayrollReport\Domain\ValueObject\SalaryWithBonus;
use App\Module\PayrollReport\Domain\ValueObject\Surname;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;

final class PayrollReportRow
{
    private function __construct(
        private Identifier $id,
        private Identifier $payrollReportId,
        private Name $name,
        private Surname $surname,
        private RemunerationBase $remunerationBase,
        private AdditionToBase $additionToBase,
        private BonusInterface $bonus,
        private SalaryWithBonus $salaryWithBonus,
    ) {
    }

    public static function createForEmployee(
        IdentifierGeneratorInterface $identifierGenerator,
        PayrollReport $payrollReport,
        Employee $employee
    ): self {
        $department = $employee->getDepartment();

        return new self(
            $identifierGenerator->generate(),
            $payrollReport->getId(),
            $employee->getName(),
            $employee->getSurname(),
            $employee->getRemunerationBase(),
            new AdditionToBase(100),
            $employee->getDepartment()->getBonus(),
            new SalaryWithBonus(100)
        );
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getPayrollReportId(): Identifier
    {
        return $this->payrollReportId;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getSurname(): Surname
    {
        return $this->surname;
    }

    public function getRemunerationBase(): RemunerationBase
    {
        return $this->remunerationBase;
    }

    public function getAdditionToBase(): AdditionToBase
    {
        return $this->additionToBase;
    }

    public function getBonus(): BonusInterface
    {
        return $this->bonus;
    }

    public function getSalaryWithBonus(): SalaryWithBonus
    {
        return $this->salaryWithBonus;
    }
}