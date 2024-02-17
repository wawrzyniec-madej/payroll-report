<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusNameEnum;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Employee;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\ValueObject\Identifier;
use App\Shared\Domain\ValueObject\Money;

final class SeniorityBonus extends Bonus
{
    public function __construct(
        Identifier $id,
        private readonly Money $yearlyBonus,
        private readonly YearsOfSeniority $maximumThreshold
    ) {
        parent::__construct(
            $id,
            BonusNameEnum::SENIORITY
        );
    }

    public function calculateForEmployee(Employee $employee): BonusDetails
    {
        $bonus = $this->calculateYearlyBonusFromSeniority(
            $employee->getYearsOfSeniority()
        );

        $salaryWithBonus = $employee->getBaseSalary()->add($bonus);

        return new BonusDetails(
            $this->getName(),
            $bonus,
            $salaryWithBonus
        );
    }

    private function calculateYearlyBonusFromSeniority(
        YearsOfSeniority $employeeSeniority
    ): Money {
        $limitedSeniority = $employeeSeniority->isGreaterThan($this->maximumThreshold)
            ? $this->maximumThreshold->getValue()
            : $employeeSeniority->getValue();

        return $this->yearlyBonus->multiply($limitedSeniority);
    }
}