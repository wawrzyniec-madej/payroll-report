<?php

namespace App\Module\PayrollReport\Domain\Collection;

use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<Employee> */
final class EmployeeCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Employee::class;
    }
}