<?php

namespace App\Module\PayrollReport\Domain\Interface;

use App\Module\PayrollReport\Domain\ValueObject\BonusDetails;
use App\Module\PayrollReport\Domain\ValueObject\Employee;

interface GetBonusDetailsInterface
{
    public function getForEmployee(Employee $employee): BonusDetails;
}