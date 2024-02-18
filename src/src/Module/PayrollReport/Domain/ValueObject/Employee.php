<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

final readonly class Employee
{
    public function __construct(
        private EmployeeName $name,
        private EmployeeSurname $surname,
        private Money $remunerationBase,
        private Identifier $departmentId,
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

    public function getDepartmentId(): Identifier
    {
        return $this->departmentId;
    }

    public function getYearsOfSeniority(): YearsOfSeniority
    {
        return $this->yearsOfSeniority;
    }
}
