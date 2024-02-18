<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Interface;

use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Employee;

interface BonusInterface
{
    public function calculateForEmployee(Employee $employee): BonusDetails;
}
