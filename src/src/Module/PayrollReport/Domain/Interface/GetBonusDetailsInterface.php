<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\Exception\CannotGetBonusDetailsException;
use App\Module\PayrollReport\Domain\Exception\InvalidYearsOfSeniorityException;
use App\Module\PayrollReport\Domain\ValueObject\BonusDetails;
use App\Module\PayrollReport\Domain\ValueObject\Employee;
use App\Shared\Domain\Exception\IncompatibleMoneyException;

interface GetBonusDetailsInterface
{
    /**
     * @throws InvalidYearsOfSeniorityException
     * @throws IncompatibleMoneyException
     * @throws CannotGetBonusDetailsException
     */
    public function getForEmployee(Employee $employee): BonusDetails;
}
