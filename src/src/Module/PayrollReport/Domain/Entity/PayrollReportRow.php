<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\Entity;

use App\Module\PayrollReport\Domain\Exception\CannotCalculateBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\Interface\CalculateBonusDetailsInterface;
use App\Module\PayrollReport\Domain\Interface\GetDepartmentInterface;
use App\Module\PayrollReport\Domain\ValueObject\BonusName;
use App\Module\PayrollReport\Domain\ValueObject\DepartmentName;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeName;
use App\Module\PayrollReport\Domain\ValueObject\EmployeeSurname;
use App\Shared\Domain\Exception\IncompatibleMoneyException;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

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

    /**
     * @throws CannotCalculateBonusDetailsException
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     * @throws CannotGetDepartmentException
     */
    public static function generate(
        Identifier $identifier,
        Employee $employee,
        CalculateBonusDetailsInterface $getBonusDetails,
        GetDepartmentInterface $getDepartment
    ): self {
        $department = $getDepartment->getById($employee->getDepartmentId());

        $bonusDetails = $getBonusDetails->calculate(
            $employee->getRemunerationBase(),
            $employee->getYearsOfSeniority(),
            $department->getBonusId()
        );

        return new self(
            $identifier,
            $employee->getName(),
            $employee->getSurname(),
            $employee->getRemunerationBase(),
            $department->getName(),
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
