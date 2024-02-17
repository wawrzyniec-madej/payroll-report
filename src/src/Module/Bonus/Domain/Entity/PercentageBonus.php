<?php

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusNameEnum;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Employee;
use App\Module\Bonus\Domain\ValueObject\Name;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Percentage;

final class PercentageBonus extends Bonus
{
    public function __construct(
        Identifier $id,
        private readonly Percentage $percentage,
    ) {
        parent::__construct(
            $id,
            BonusNameEnum::PERCENTAGE
        );
    }

    public function calculateForEmployee(Employee $employee): BonusDetails
    {
        $bonus = $employee->getBaseSalary()->multiplyByPercentage($this->percentage);

        $salaryWithBonus = $employee->getBaseSalary()->add($bonus);

        return new BonusDetails(
            $this->getName(),
            $bonus,
            $salaryWithBonus,
        );
    }
}