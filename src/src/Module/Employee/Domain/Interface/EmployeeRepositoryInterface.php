<?php

declare(strict_types=1);

namespace App\Module\Employee\Domain\Interface;

use App\Module\Employee\Domain\Collection\EmployeeCollection;
use App\Shared\Domain\Exception\InvalidDateTimeException;

interface EmployeeRepositoryInterface
{
    /**
     * @throws InvalidDateTimeException
     */
    public function getAll(): EmployeeCollection;
}
