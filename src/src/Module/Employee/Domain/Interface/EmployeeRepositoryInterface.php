<?php

namespace App\Module\Employee\Domain\Interface;

use App\Module\Employee\Domain\Collection\EmployeeCollection;

interface EmployeeRepositoryInterface
{
    public function getAll(): EmployeeCollection;
}
