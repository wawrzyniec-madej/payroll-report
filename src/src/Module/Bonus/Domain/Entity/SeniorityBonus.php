<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

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

    public function calculate(Money $remunerationBase, YearsOfSeniority $yearsOfSeniority): BonusDetails
    {
        return new BonusDetails(
            $this->getName(),
            $this->calculateYearlyBonusFromSeniority($yearsOfSeniority)
        );
    }

    private function calculateYearlyBonusFromSeniority(
        YearsOfSeniority $employeeSeniority
    ): Money {
        $limitedSeniority = $employeeSeniority->isGreaterThan($this->employmentThreshold)
            ? $this->employmentThreshold->getValue()
            : $employeeSeniority->getValue();

        return new Money(
            $this->yearlyBonus->getAmount() * $limitedSeniority,
            $this->yearlyBonus->getCurrency()
        );
    }
}
