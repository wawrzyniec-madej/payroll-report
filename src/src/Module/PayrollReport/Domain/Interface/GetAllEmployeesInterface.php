<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;
use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\InvalidDateTimeException;

interface GetAllEmployeesInterface
{
    /**
     * @throws InvalidYearsOfSeniorityException
     * @throws CollectionElementInvalidException
     * @throws InvalidDateTimeException
     * @throws CannotGetDepartmentException
     */
    public function getAll(): EmployeeCollection;
}
