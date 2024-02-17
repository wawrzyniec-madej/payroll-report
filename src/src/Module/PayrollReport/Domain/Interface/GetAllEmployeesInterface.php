<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Collection\EmployeeCollection;

interface GetAllEmployeesInterface
{
    public function getAll(): EmployeeCollection;
}