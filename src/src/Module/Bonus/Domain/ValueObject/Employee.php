<?php

namespace App\Module\Bonus\Domain\ValueObject;

use App\Shared\Domain\Money;

final readonly class Employee
{
    public function __construct(
        private Money $baseSalary,
        private YearsOfSeniority $yearsOfSeniority,
    ) {
    }

    public function getBaseSalary(): Money
    {
        return $this->baseSalary;
    }

    public function getYearsOfSeniority(): YearsOfSeniority
    {
        return $this->yearsOfSeniority;
    }
}
