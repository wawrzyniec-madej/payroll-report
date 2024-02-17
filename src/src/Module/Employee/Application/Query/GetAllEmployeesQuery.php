<?php

namespace App\Module\Employee\Application\Query;

use App\Module\Employee\Domain\Collection\EmployeeCollection;
use App\Module\Employee\Domain\Interface\EmployeeRepositoryInterface;

final readonly class GetAllEmployeesQuery
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository
    ) {
    }

    public function get(): EmployeeCollection
    {
        return $this->employeeRepository->getAll();
    }
}