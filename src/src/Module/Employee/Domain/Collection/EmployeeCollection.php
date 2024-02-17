<?php

namespace App\Module\Employee\Domain\Collection;

use App\Module\Employee\Domain\Entity\Employee;
use App\Shared\Domain\TypedCollection;

/** @extends TypedCollection<Employee> */
final class EmployeeCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Employee::class;
    }
}