<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Money;

final readonly class Employee
{
    public function __construct(
        private EmployeeName $name,
        private EmployeeSurname $surname,
        private Money $remunerationBase,
        private Department $department,
        private YearsOfSeniority $yearsOfSeniority
    ) {
    }

    public function getSurname(): EmployeeSurname
    {
        return $this->surname;
    }

    public function getName(): EmployeeName
    {
        return $this->name;
    }

    public function getRemunerationBase(): Money
    {
        return $this->remunerationBase;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getYearsOfSeniority(): YearsOfSeniority
    {
        return $this->yearsOfSeniority;
    }
}
