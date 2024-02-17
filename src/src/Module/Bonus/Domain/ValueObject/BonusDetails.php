<?php

namespace App\Module\Bonus\Domain\ValueObject;

use App\Shared\Domain\ValueObject\Money;

final class BonusDetails
{
    public function __construct(
        private readonly Money $bonus,
        private readonly Money $salaryWithBonus
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
}