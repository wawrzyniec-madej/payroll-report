<?php

declare(strict_types=1);

namespace App\Module\Employee\Application\Query;

use App\Module\Employee\Domain\Collection\EmployeeCollection;
use App\Module\Employee\Domain\Interface\EmployeeRepositoryInterface;
use App\Shared\Domain\Exception\InvalidDateTimeException;

final readonly class GetAllEmployeesQuery
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository
    ) {
    }

    /**
     * @throws InvalidDateTimeException
     */
    public function get(): EmployeeCollection
    {
        return $this->employeeRepository->getAll();
    }
}
