<?php

namespace App\Module\Bonus\Domain\ValueObject;

use App\Module\Bonus\Domain\Enum\BonusNameEnum;
use App\Shared\Domain\ValueObject\Money;

final readonly class BonusDetails
{
    public function __construct(
        private BonusNameEnum $name,
        private Money $bonus,
        private Money $salaryWithBonus
    ) {
    }

    public function getBonus(): Money
    {
        return $this->bonus;
    }

    public function getSalaryWithBonus(): Money
    {
        return $this->salaryWithBonus;
    }

    public function getName(): BonusNameEnum
    {
        return $this->name;
    }
}