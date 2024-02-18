<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Collection;

use App\Module\Employee\Domain\Entity\Employee;
use App\Shared\Components\TypedCollection;

/** @extends TypedCollection<Employee> */
final class EmployeeCollection extends TypedCollection
{
    public function typeAllowed(): string
    {
        return Employee::class;
    }
}
