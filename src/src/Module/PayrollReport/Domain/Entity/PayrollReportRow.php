<?php

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Interface\GetBonusDetailsInterface;
use App\Module\PayrollReport\Domain\ValueObject\BonusName;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeSurname;
use App\Module\PayrollReport\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Interface\IdentifierGeneratorInterface;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;

final readonly class PayrollReportRow
{
    private function __construct(
        private Identifier $id,
        private EmployeeName $employeeName,
        private EmployeeSurname $employeeSurname,
        private Money $remunerationBase,
        private DepartmentName $departmentName,
        private BonusName $bonusName,
        private Money $additionToBase,
        private Money $salaryWithBonus
    ) {
    }

    public static function recreate(
        Identifier $id,
        EmployeeName $employeeName,
        EmployeeSurname $employeeSurname,
        Money $remunerationBase,
        DepartmentName $departmentName,
        BonusName $bonusName,
        Money $additionToBase,
        Money $salaryWithBonus
    ): self {
        return new self(
            $id,
            $employeeName,
            $employeeSurname,
            $remunerationBase,
            $departmentName,
            $bonusName,
            $additionToBase,
            $salaryWithBonus,
        );
    }

    public static function generate(
        IdentifierGeneratorInterface $identifierGenerator,
        Employee $employee,
        GetBonusDetailsInterface $getBonusDetails
    ): self {
        $bonusDetails = $getBonusDetails->getForEmployee($employee);

        return new self(
            $identifierGenerator->generate(),
            $employee->getName(),
            $employee->getSurname(),
            $employee->getRemunerationBase(),
            $employee->getDepartment()->getName(),
            $bonusDetails->getName(),
            $bonusDetails->getAdditionToBase(),
            $bonusDetails->getSalaryWithBonus(),
        );
    }

    public function getId(): Identifier
    {
        return $this->id;
    }

    public function getEmployeeName(): EmployeeName
    {
        return $this->employeeName;
    }

    public function getEmployeeSurname(): EmployeeSurname
    {
        return $this->employeeSurname;
    }

    public function getRemunerationBase(): Money
    {
        return $this->remunerationBase;
    }

    public function getDepartmentName(): DepartmentName
    {
        return $this->departmentName;
    }

    public function getBonusName(): BonusName
    {
        return $this->bonusName;
    }

    public function getAdditionToBase(): Money
    {
        return $this->additionToBase;
    }

    public function getSalaryWithBonus(): Money
    {
        return $this->salaryWithBonus;
    }
}