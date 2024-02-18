<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Money;
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
            BonusTypeEnum::PERCENTAGE
        );
    }

    public function calculate(Money $remunerationBase, YearsOfSeniority $yearsOfSeniority): BonusDetails
    {
        return new BonusDetails(
            $this->getName(),
            $remunerationBase->multiplyByPercentage($this->percentage)
        );
    }
}
