<?php

namespace App\Module\Employee\Domain\Interface;

use App\Module\Employee\Domain\Collection\EmployeeCollection;
use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Shared\Domain\Exception\InvalidDateTimeException;

interface EmployeeRepositoryInterface
{
    /**
     * @throws InvalidDateTimeException
     * @throws CollectionElementInvalidException
     */
    public function getAll(): EmployeeCollection;
}
