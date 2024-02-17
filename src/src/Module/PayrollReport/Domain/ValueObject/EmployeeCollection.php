<?php

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<Employee> */
final class EmployeeCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Employee::class;
    }
}