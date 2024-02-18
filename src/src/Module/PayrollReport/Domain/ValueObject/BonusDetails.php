<?php

declare(strict_types=1);

namespace App\Module\PayrollReport\Domain\ValueObject;

use App\Shared\Domain\Money;

final readonly class BonusDetails
{
    public function __construct(
        private BonusName $name,
        private Money $additionToBase,
        private Money $salaryWithBonus
    ) {
    }

    public function getSalaryWithBonus(): Money
    {
        return $this->salaryWithBonus;
    }

    public function getAdditionToBase(): Money
    {
        return $this->additionToBase;
    }

    public function getName(): BonusName
    {
        return $this->name;
    }
}
