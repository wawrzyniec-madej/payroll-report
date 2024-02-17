<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
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
        private readonly YearsOfSeniority $employmentThreshold
    ) {
        parent::__construct(
            $id,
            BonusTypeEnum::SENIORITY
        );
    }

    public function calculateForEmployee(Employee $employee): BonusDetails
    {
        $bonus = $this->calculateYearlyBonusFromSeniority(
            $employee->getYearsOfSeniority()
        );

        return new BonusDetails(
            $this->getName(),
            $bonus
        );
    }

    private function calculateYearlyBonusFromSeniority(
        YearsOfSeniority $employeeSeniority
    ): Money {
        $limitedSeniority = $employeeSeniority->isGreaterThan($this->employmentThreshold)
            ? $this->employmentThreshold->getValue()
            : $employeeSeniority->getValue();

        return $this->yearlyBonus->multiply($limitedSeniority);
    }
}
