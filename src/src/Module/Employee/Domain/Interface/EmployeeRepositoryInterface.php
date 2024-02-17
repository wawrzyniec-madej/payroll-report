<?php

namespace App\Module\Employee\Domain\Interface;

use App\Module\Employee\Domain\Entity\Employee;
use App\Module\Employee\Domain\Exception\EmployeeNotFoundException;
use App\Shared\Domain\ValueObject\Identifier;

interface EmployeeRepositoryInterface
{
    /** @throws EmployeeNotFoundException */
    public function getOneById(Identifier $identifier): Employee;
}