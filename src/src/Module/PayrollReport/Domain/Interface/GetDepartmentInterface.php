<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Exception\CannotGetDepartmentException;
use App\Module\PayrollReport\Domain\ValueObject\Department;
use App\Shared\Domain\ValueObject\Identifier;

interface GetDepartmentInterface
{
    /** @throws CannotGetDepartmentException */
    public function getById(Identifier $departmentId): Department;
}