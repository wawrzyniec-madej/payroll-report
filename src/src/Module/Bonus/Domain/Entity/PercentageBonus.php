<?php

declare(strict_types=1);

namespace App\Module\Bonus\Domain\Entity;

use App\Module\Bonus\Domain\Enum\BonusTypeEnum;
use App\Module\Bonus\Domain\ValueObject\BonusDetails;
use App\Module\Bonus\Domain\ValueObject\Percentage;
use App\Module\Bonus\Domain\ValueObject\YearsOfSeniority;
use App\Shared\Domain\Money;
use App\Shared\Domain\ValueObject\Identifier;

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
            $this->getType(),
            new Money(
                (int) floor($remunerationBase->getAmount() * $this->percentage->getFloat()),
                $remunerationBase->getCurrency()
            )
        );
    }
}
